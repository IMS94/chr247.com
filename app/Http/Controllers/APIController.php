<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Dosage;
use App\DosageFrequency;
use App\DosagePeriod;
use App\Drug;
use App\Patient;
use App\Payment;
use App\Prescription;
use App\PrescriptionDrug;
use App\PrescriptionPharmacyDrug;
use App\Queue;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use \Log;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller {
    /**
     * Get the clinic's drugs
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDrugs() {
        $clinic = Clinic::getCurrentClinic();
        $data = $clinic->drugs()->orderBy('name')->select('id', 'name', 'quantity')->get()->toArray();
        return response()->json($data);
    }


    /**
     * Get the Dosages, Frequencies and Periods of the clinic
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDosages() {
        $clinic = Clinic::getCurrentClinic();
        $dosages = $clinic->dosages()->orderBy('description')->select('id', 'description')->get()->toArray();
        $frequencies = $clinic->dosageFrequencies()->orderBy('description')->select('id', 'description')->get()->toArray();
        $periods = $clinic->dosagePeriods()->orderBy('description')->select('id', 'description')->get()->toArray();

        return response()->json(['dosages' => $dosages, 'frequencies' => $frequencies, 'periods' => $periods]);
    }


    /**
     * Saves a prescription
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePrescription(Request $request) {
        $validator = \Validator::make($request->all(), [
            'id'                      => 'required|exists:patients,id',
            'complaints'              => 'required_without:diagnosis|max:150',
            'diagnosis'               => 'required_without:complaints|max:150',
            'investigations'          => 'max:150',
            'remarks'                 => 'max:150',
            'prescribedDrugs'         => 'array',
            'prescribedDrugs.*.drug'  => 'required_with:prescribedDrugs',
            'prescribedDrugs.*.dose'  => 'required_with:prescribedDrugs',
            'pharmacyDrugs'           => 'array',
            'pharmacyDrugs.*.name'    => 'required_with:pharmacyDrugs',
            'pharmacyDrugs.*.remarks' => 'max:200'
        ]);

        $patient = Patient::find($request->id);
        if (Gate::denies('prescribeMedicine', $patient)) {
            return response()->json(['status' => 0, 'message' => 'Unauthorized action'], 404);
        }

        //at least on of the complaints and diagnosis has to be present
        if ($validator->fails()) {
            return response()->json(['status' => 0], 404);
        }

        $prescription = new Prescription();

        DB::beginTransaction();
        try {
            $prescription->complaints = $request->complaints;
            $prescription->investigations = $request->investigations;
            $prescription->diagnosis = $request->diagnosis;
            $prescription->remarks = $request->remarks ?: "";
            $prescription->creator()->associate(User::getCurrentUser());
            $prescription->patient()->associate($patient);
            $prescription->save();

            //save the prescribed drugs
            foreach ($request->prescribedDrugs as $prescribedDrug) {
                $drug = new PrescriptionDrug();
                $drug->dosage()->associate(Dosage::find($prescribedDrug['dose']['id']));
                $drug->frequency()->associate(DosageFrequency::find($prescribedDrug['frequency']['id']));
                $drug->period()->associate(DosagePeriod::find($prescribedDrug['period']['id']));
                $drug->drug()->associate(Drug::find($prescribedDrug['drug']['id']));
                $prescription->prescriptionDrugs()->save($drug);
            }

            //save the pharmacy drugs
            foreach ($request->pharmacyDrugs as $pharmacyDrug) {
                $drug = new PrescriptionPharmacyDrug();
                $drug->drug = $pharmacyDrug['name'];
                $drug->remarks = isset($pharmacyDrug['remarks']) ? $pharmacyDrug['remarks'] : "";
                $prescription->prescriptionPharmacyDrugs()->save($drug);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return response()->json(['status' => 0], 500);
        }
        DB::commit();
        return response()->json(['status' => 1, 'prescriptionId' => $prescription->id], 200);
    }


    /**
     * Get the prescriptions of a given patient
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrescriptions($id) {
        $patient = Patient::find($id);
        if (Gate::denies('viewPrescriptions', $patient)) {
            return response()->json(['status' => 0], 404);
        }

        $prescriptions = $patient->prescriptions()->where('issued', false)
            ->with('prescriptionDrugs.dosage', 'prescriptionDrugs.frequency', 'prescriptionPharmacyDrugs',
                'prescriptionDrugs.period', 'prescriptionDrugs.drug.quantityType')->get();
        return response()->json(['prescriptions' => $prescriptions, 'status' => 1]);
    }

    /**
     * Get the prescriptions to be issued of the clinic.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllRemainingPrescriptions() {
        if (Gate::denies('issueMedicine', 'App\Patient')) {
            return response()->json(['status' => 0], 404);
        }

        $clinic = Clinic::getCurrentClinic();
        Log::info($clinic->patients()->count());
        $prescriptions = Prescription::whereIn('patient_id', $clinic->patients()->lists('id'))
            ->where('issued', false)->orderBy('id')
            ->with('prescriptionDrugs.dosage', 'prescriptionDrugs.frequency', 'prescriptionPharmacyDrugs',
                'prescriptionDrugs.period', 'prescriptionDrugs.drug.quantityType', 'patient')->get();
        return response()->json(['prescriptions' => $prescriptions, 'status' => 1]);
    }


    /**
     * Issue a prescription.
     * Mark prescription as issued. Then register the payment.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function issuePrescription(Request $request) {
        $prescription = Prescription::find($request->prescription['id']);
        if (empty($prescription) || Gate::denies('issuePrescription', $prescription)) {
            return response()->json(['status' => 0], 404);
        }

        $validator = Validator::make($request->all(), [
            'prescription'                                     => 'required',
            'prescription.id'                                  => 'required',
            'prescription.payment'                             => 'required|numeric',
            'prescription.prescription_drugs'                  => 'array',
            'prescription.prescription_drugs.*.issuedQuantity' => 'numeric'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['status' => 0, 'message' => $errors[0]], 404);
        }
        if ($prescription->issued) {
            return response()->json(['status' => -1, 'message' => "Prescription is already issued"], 200);
        }
        if ($prescription->prescriptionDrugs()->count() != count($request->prescription['prescription_drugs'])) {
            return response()->json(['status' => -1, 'message' => "Invalid prescription"], 403);
        }

        DB::beginTransaction();
        try {
            //mark prescription as updated
            $prescription->issued = true;
            $prescription->issued_at = date('Y-m-d H:i:s');
            $prescription->update();

            //save payment details
            $payment = new Payment();
            $payment->prescription()->associate($prescription);
            $payment->amount = $request->prescription['payment'];
            $payment->remarks = $request->prescription['paymentRemarks'];
            $payment->save();

            //save prescription drug quantities and decrease stocks
            foreach ($request->prescription['prescription_drugs'] as $prescription_drug) {
                //setting issued quantity of each drug in the prescription
                $prescriptionDrug = $prescription->prescriptionDrugs()
                    ->where('id', $prescription_drug['id'])->first();
                $prescriptionDrug->quantity = $prescription_drug['issuedQuantity'];
                $prescriptionDrug->update();

                //decreasing stocks
                $drug = $prescriptionDrug->drug;
                $drug->quantity = $drug->quantity - $prescription_drug['issuedQuantity'];
                $drug->update();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(['status' => 1]);
    }


    /**
     * Deletes a prescription.
     * Authorizes before deleting whether the user has permissions to delete the prescription.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePrescription($id) {
        $prescription = Prescription::find($id);
        if (empty($prescription) || Gate::denies('deletePrescription', $prescription)) {
            return response()->json(['status' => 0, 'message' => 'You are not authorized to delete prescriptions'], 404);
        }
        if ($prescription->issued) {
            return response()->json(['status'  => 0,
                                     'message' => "The prescription is already issued. Therefore cannot be deleted"], 500);
        }
        DB::beginTransaction();
        try {
//            if($prescription->prescriptionDrugs()->count()>0) {
            $prescription->prescriptionDrugs()->delete();
            $prescription->prescriptionPharmacyDrugs()->delete();
//            }
            $prescription->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(['status' => 1]);
    }


    /**
     * Get the medical records of a patient.
     *
     * @param $patientId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMedicalRecords($patientId) {
        $patient = Patient::find($patientId);
        if (Gate::denies('viewMedicalRecords', $patient)) {
            return response()->json(['status' => 0], 404);
        }

        $prescriptions = $patient->prescriptions()->where('issued', true)->orderBy('issued_at')
            ->with('prescriptionDrugs.dosage', 'prescriptionDrugs.frequency', 'prescriptionPharmacyDrugs',
                'prescriptionDrugs.period', 'prescriptionDrugs.drug.quantityType',
                'payment')->get();
        return response()->json(['prescriptions' => $prescriptions, 'status' => 1]);
    }


    /*
     * ================= Queue Management ============================
     */

    /**
     * Get the patients in the current queue
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQueue() {
        $queue = Queue::getCurrentQueue();
        if (is_null($queue)) {
            return response()->json(['status' => 1, 'patients' => []]);
        }
        $patients = $queue->patients()->withPivot(['id', 'inProgress'])
            ->wherePivot('completed', false)->orderBy('pivot_inProgress', 'desc')->orderBy('pivot_id')->get();
        return response()->json(['status' => 1, 'patients' => $patients]);
    }


    /**
     * Update the current queue
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQueue(Request $request) {
        $queue = Queue::getCurrentQueue();
        $patient = Patient::find($request->patient['id']);
        $this->authorize('update', [$queue, $patient]);

        $patient = $queue->patients()->wherePivot('completed', false)->find($patient->id);
        if (empty($patient)) {
            return response()->json(['status' => 0, 'message' => "Patient not in the queue"]);
        }
        $patient->pivot->inProgress =
            $request->patient['pivot']['inProgress'] == 1 ? true : false;
        $patient->pivot->completed = $request->patient['pivot']['inProgress'] == 2 ? true : false;
        $patient->pivot->update();
        return response()->json(['status' => 1]);
    }
}
