<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Exceptions\NotFoundException;
use App\Patient;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class PatientController extends Controller
{
    /**
     * Get the patients list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPatientList()
    {
        $clinic = Clinic::getCurrentClinic();
        $patients = $clinic->patients;
        return view('patients.patients', ['patients' => $patients]);
    }


    /**
     * Adds a patient to the system
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addPatient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'gender' => 'required|in:Male,Female',
            'nic' => 'regex:/[0-9]{9}[vV]/',
            'bloodGroup' => 'required|in:A +,A -,B +,B -,AB +,AB -,O +,O -,N/A'
        ]);

        if ($validator->fails()) {
            return back()->with('type', 'patient')->withErrors($validator)->withInput();
        }

        $clinic = Clinic::getCurrentClinic();

        /*
         * Checks if the same clinic has a patient in the same nic. If yes, it is notified.
         */
        if (!empty($request->nic) && $clinic->patients()->where('nic', $request->nic)->count() > 0) {
            $validator->getMessageBag()->add('nic', 'A patient with this NIC already exists');
            return back()->with('type', 'patient')->withInput()->withErrors($validator);
        }

        $patient = new Patient();
        $patient->first_name = $request->firstName;
        $patient->last_name = $request->lastName ?: null;
        $patient->dob = $request->dob ?: null;
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
            $patient->user()->associate(Auth::user());
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
     *
     * Edits a patient
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws NotFoundException
     */
    public function editPatient($id, Request $request)
    {
        $patient = Patient::find($id);
        if (empty($patient)) {
            throw new NotFoundException("Patient Not Found");
        }
        $this->authorize('edit', $patient);

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'gender' => 'required|in:Male,Female',
            'nic' => 'regex:/[0-9]{9}[vV]/',
            'bloodGroup' => 'required|in:A +,A -,B +,B -,AB +,AB -,O +,O -,N/A'
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
        $patient->dob = $request->dob ?: null;
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
    public function getPatient($id)
    {
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
    public function deletePatient($id)
    {
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
}
