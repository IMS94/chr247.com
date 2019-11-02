<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Exceptions\NotFoundException;
use App\Patient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller {
    
    /**
     * Get the patients list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPatientList() {
        $clinic = Clinic::getCurrentClinic();
        return view('patients.patients', ['patients' => []]);
    }


    /**
     * Get the patients list for data tables, server side processing
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listPatients(Request $request)
    {
        $clinic = Clinic::getCurrentClinic();

        $draw = $request->query('draw');
        $start = $request->query('start');
        $length = $request->query('length');
        $search = $request->query('search');
        $order = $request->query('order');
        $query = $search['value'];
        $orderByColIdx = $order[0]["column"];
        $orderByDirection = $order[0]["dir"];

        $orderByCol = 'first_name';
        if ($orderByColIdx == 2) {
            $orderByCol = 'phone';
        } else if ($orderByColIdx == 3) {
            $orderByCol = 'address';
        } else if ($orderByColIdx == 4) {
            $orderByCol = 'dob';
            $orderByDirection = $orderByDirection == 'asc' ? 'desc' : 'asc';
        }

        Log::debug("Draw -> $draw, Start-> $start, Length-> $length, OrderByColumn-> $orderByColIdx, Query-> $query");

        $totalRecords = $clinic->patients()->count();
        $filteredRecords = $totalRecords;

        $patients = $clinic->patients();

        if (!empty($query)) {
            $patients = $patients->where('first_name', 'like', "%$query%")
                ->orWhere('last_name', 'like', "%$query%");
            $filteredRecords = $patients->count();
        }

        $patients = $patients->orderBy($orderByCol, $orderByDirection)
            ->skip($start)->take($length)->get();

        $data = [];
        foreach ($patients as $patient) {
            $buttons = '';
            if (\Gate::allows('delete', $patient)) {
                $buttons = "
                    <button class=\"btn btn-sm btn-danger\" data-toggle=\"modal\"
                        data-target=\"#confirmDeletePatientModal\"
                        onclick=\"showConfirmDelete($patient->id,'$patient->first_name $patient->last_name')\">
                        <i class=\"fa fa-recycle fa-lg\" data-toggle=\"tooltip\"
                        data-placement=\"bottom\" title=\"\"
                        data-original-title=\"Delete this patient?
                        You won't be able to delete this patient if the patient has any records
                        associated to him/her in the system.\"></i>
                    </button>";
            }

            $row = [
                $patient->id,
                $patient->first_name . ' ' . $patient->last_name,
                $patient->phone,
                $patient->address,
                \Utils::getAge($patient->dob),
                $buttons
            ];

            $data[] = $row;
        }

        $result = [
            'draw' => $request->query('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($result);
    }

    /**
     * Adds a patient to the system
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addPatient(Request $request) {
        // authorizing the user for the ability to add patients
        $this->authorize('add', 'App\Patient');

        $validator = Validator::make($request->all(), [
            'firstName'  => 'required',
            'gender'     => 'required|in:Male,Female',
            'nic'        => 'regex:/[0-9]{9}[vV]/',
            'bloodGroup' => 'required|in:A +,A -,B +,B -,AB +,AB -,O +,O -,N/A',
            'dob'        => 'date|date_format:Y/m/d|before:' . date('Y-m-d') . '|after:' .
                date('Y-m-d', strtotime(date('Y-m-d') . ' -150 year'))
        ]);

        if ($validator->fails()) {
            return back()->with('type', 'patient')->withErrors($validator)->withInput();
        }

        $clinic = Clinic::getCurrentClinic();

        // Checks if the same clinic has a patient in the same nic. If yes, it is notified.
        if (!empty($request->nic) && $clinic->patients()->where('nic', $request->nic)->count() > 0) {
            $validator->getMessageBag()->add('nic', 'A patient with this NIC already exists');
            Log::error($validator->errors());
            return back()->with('type', 'patient')->withInput()->withErrors($validator);
        }

        $patient = new Patient();
        $patient->first_name = $request->firstName;
        $patient->last_name = $request->lastName ?: null;
        $patient->dob = $request->dob ? date('Y-m-d', strtotime($request->dob)) : null;
        $patient->gender = $request->gender;
        $patient->address = $request->address ?: null;
        $patient->nic = $request->nic ?: null;
        $patient->phone = $request->phone ?: null;
        $patient->blood_group = $request->bloodGroup;
        $patient->allergies = $request->allergies ?: null;
        $patient->family_history = $request->familyHistory ?: null;
        $patient->medical_history = $request->medicalHistory ?: null;
        $patient->post_surgical_history = $request->postSurgicalHistory ?: null;
        $patient->remarks = $request->remarks ?: null;

        try {
            $patient->creator()->associate(Auth::user());
            $patient->clinic()->associate($clinic);
            $patient->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $validator->getMessageBag()
                ->add('general', 'Unable to save the patient details. A patient with similar details already exists');
            return back()->with('type', 'patient')->withInput()->withErrors($validator);
        }

        return back()->with('success', $request->firstName . ' added successfully');
    }


    /**
     * Edits a patient.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws NotFoundException
     */
    public function editPatient($id, Request $request) {
        $patient = Patient::find($id);
        if (empty($patient)) {
            throw new NotFoundException("Patient Not Found");
        }
        $this->authorize('edit', $patient);

        $validator = \Validator::make($request->all(), [
            'firstName'  => 'required',
            'gender'     => 'required|in:Male,Female',
            'nic'        => 'regex:/[0-9]{9}[vV]/',
            'bloodGroup' => 'required|in:A +,A -,B +,B -,AB +,AB -,O +,O -,N/A',
            'dob'        => 'date|date_format:Y/m/d|before:' . date('Y-m-d') . '|after:' .
                date('Y-m-d', strtotime(date('Y-m-d') . ' -150 year'))
        ]);

        if ($validator->fails()) {
            return back()->with('type', 'patient')->withErrors($validator)->withInput();
        }

        $clinic = Clinic::getCurrentClinic();

        /*
         * Checks if the same clinic has a patient in the same nic. If yes, it is notified.
         */
        if (!empty($request->nic) &&
            $clinic->patients()->where('nic', $request->nic)->where('id', '<>', $id)->count() > 0
        ) {
            $validator->getMessageBag()->add('nic', 'A patient with this NIC already exists');
            return back()->with('type', 'patient')->withInput()->withErrors($validator);
        }

        $patient->first_name = $request->firstName;
        $patient->last_name = $request->lastName ?: null;
        $patient->dob = $request->dob ? date('Y-m-d', strtotime($request->dob)) : null;
        $patient->gender = $request->gender;
        $patient->address = $request->address ?: null;
        $patient->nic = $request->nic ?: null;
        $patient->phone = $request->phone ?: null;
        $patient->blood_group = $request->bloodGroup;
        $patient->allergies = $request->allergies ?: null;
        $patient->family_history = $request->familyHistory ?: null;
        $patient->medical_history = $request->medicalHistory ?: null;
        $patient->post_surgical_history = $request->postSurgicalHistory ?: null;
        $patient->remarks = $request->remarks ?: null;

        try {
            $patient->update();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $validator->getMessageBag()->add('general', 'Unable to save the patient details.');
            return back()->with('type', 'patient')->withInput()->withErrors($validator);
        }

        return back()->with('success', 'Updated successfully');
    }


    /**
     * Get a specific patient of a clinic
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws NotFoundException
     */
    public function getPatient($id) {
        $patient = Patient::find($id);
        if (empty($patient)) {
            throw new NotFoundException("Patient Not Found");
        }
        $this->authorize('view', $patient);

        return view('patients.patient', ['patient' => $patient]);
    }


    /**
     * Delete a patient
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws NotFoundException
     */
    public function deletePatient($id) {
        $patient = Patient::find($id);
        if (empty($patient)) {
            throw new NotFoundException("Patient Not Found");
        }
        $this->authorize('delete', $patient);

        DB::beginTransaction();
        try {
            $patient->delete();
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', "Unable to delete " . $patient->first_name);
        }
        DB::commit();
        return back()->with('success', $patient->first_name . " successfully removed");
    }


    public function getPrintPreview($id) {
        $patient = Patient::find($id);
        return view('patients.printIDPreview', ['patient' => $patient]);
    }
}
