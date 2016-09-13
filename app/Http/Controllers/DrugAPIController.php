<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Dosage;
use App\DosageFrequency;
use App\DosagePeriod;
use App\Drug;
use App\DrugType;
use App\Lib\Logger;
use App\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Log;
use Validator;

/**
 * Class DrugAPIController
 *
 * @package App\Http\Controllers
 * @author Imesha Sudasingha
 */
class DrugAPIController extends Controller {
    public function getDosages() {
        $clinic = Clinic::getCurrentClinic();
        return response()->json(['status' => 1, 'dosages' => $clinic->dosages]);
    }

    public function getFrequencies() {
        $clinic = Clinic::getCurrentClinic();
        return response()->json(['status' => 1, 'frequencies' => $clinic->dosageFrequencies]);
    }

    public function getPeriods() {
        $clinic = Clinic::getCurrentClinic();
        return response()->json(['status' => 1, 'periods' => $clinic->dosagePeriods]);
    }

    public function getQuantityTypes() {
        $clinic = Clinic::getCurrentClinic();
        return response()->json(['status' => 1, 'quantityTypes' => $clinic->quantityTypes]);
    }


    /**
     * Saves a new drug which will immediately be added to the prescription.
     *
     * @param Request $request Request containing all the information about drugs and dosages
     * @return \Illuminate\Http\JsonResponse    Response: status-1 is Success, status-0 is failure
     */
    public function saveDrugWithDosages(Request $request) {
        $clinic = Clinic::getCurrentClinic();
        $validator = Validator::make($request->all(), [
            'drug' => 'required_without:drugName|numeric|exists:drugs,id,clinic_id,' . $clinic->id,
            'drugName' => 'required_without:drug|max:200|min:2',
            'quantityType' => 'required_with:drugName|alpha|min:2|max:100',
            'dosage' => 'required_without:dosageText|exists:dosages,id,clinic_id,' . $clinic->id,
            'dosageText' => 'required_without:dosage|min:2|max:100',
            'frequency' => 'exists:frequencies,id,clinic_id,' . $clinic->id,
            'frequencyText' => 'min:2|max:100',
            'period' => 'exists:periods,id,clinic_id,' . $clinic->id,
            'periodText' => 'min:2|max:100',
        ]);
        if ($validator->fails()) {
            Logger::error("Validation error", $validator->errors()->toArray());
            $errors = $validator->errors()->toArray();
            $errors['status'] = 0;
            return response()->json($errors);
        }
        $user = User::getCurrentUser();
        $prescriptionDrug = null;
        DB::beginTransaction();
        try {
            $dosage = $this->addDosage($request, $clinic, $user);
            $frequency = $this->addFrequency($request, $clinic, $user);
            $period = $this->addPeriod($request, $clinic, $user);
            $quantityType = $this->addQuantityType($request, $clinic, $user);
            $drug = $this->addDrug($request, $clinic, $user, $quantityType);
            $prescriptionDrug = [
                'drug' => $drug,
                'dose' => $dosage,
                'frequency' => $frequency,
                'period' => $period
            ];
        } catch (Exception $e) {
            Logger::error($e->getMessage(), $request->all());
            DB::rollBack();
            return response()->json([
                'status' => 0
            ]);
        }
        DB::commit();
        return response()->json(['status' => 1, 'drug' => $prescriptionDrug]);
    }

    private function addDosage(Request $request, Clinic $clinic, User $user) {
        $dosage = null;
        if (isset($request->dosage))
            $dosage = $clinic->dosages()->find($request->dosage);
        else
            $dosage = $clinic->dosages()->where("description", 'LIKE', $request->dosageText)->first();

        if (is_null($dosage)) {
            $dosage = new Dosage();
            $dosage->description = $request->dosageText;
            $dosage->creator()->associate($user);
            $clinic->dosages()->save($dosage);
        }
        return $dosage;
    }

    private function addFrequency(Request $request, Clinic $clinic, User $user) {
        $frequency = null;
        if (isset($request->frequency))
            $frequency = $clinic->dosageFrequencies()->find($request->frequency);
        else
            $frequency = $clinic->dosageFrequencies()->where("description", 'LIKE', $request->frequencyText)->first();

        if ($frequency == null) {
            $frequency = new DosageFrequency();
            $frequency->description = $request->frequencyText;
            $frequency->creator()->associate($user);
            $clinic->dosages()->save($frequency);
        }
        return $frequency;
    }

    private function addPeriod(Request $request, Clinic $clinic, User $user) {
        $period = null;
        if (isset($request->period))
            $period = $clinic->dosagePeriods()->find($request->period);
        else
            $period = $clinic->dosagePeriods()->where("description", 'LIKE', $request->periodText)->first();
        if ($period == null) {
            $period = new DosagePeriod();
            $period->description = $request->periodText;
            $period->creator()->associate($user);
            $clinic->dosages()->save($period);
        }
        return $period;
    }

    private function addQuantityType(Request $request, Clinic $clinic, User $user) {
        if (!isset($request->quantityType))
            return null;
        $quantityType = $clinic->quantityTypes()->where('drug_type', 'LIKE', $request->quantityType)->first();
        if ($quantityType == null) {
            $quantityType = new DrugType();
            $quantityType->drug_type = $request->quantityType;
            $quantityType->creator()->associate($user);
            $clinic->quantityTypes()->save($quantityType);
        }
        return $quantityType;
    }

    /**
     * Helper method when adding an immediate drug to the prescription. If the user has selected a drug, it will
     * be selected. Else, checked whether the corresponding drug name is available with given quantity type.
     * If it is not available, a new drug is created.
     *
     * @param Request $request Request containing all the data
     * @param Clinic $clinic User's clinic
     * @param User $user Current user
     * @param DrugType|null $quantityType Drug's quantity type
     * @return Drug|null The drug which was added or existed
     */
    private function addDrug(Request $request, Clinic $clinic, User $user, DrugType $quantityType = null) {
        $drug = null;
        if (isset($request->drug))
            $drug = $clinic->drugs()->find($request->drug);
        else {
            $drug = $clinic->drugs()->where('name', $request->drugName)
                ->where('drug_type_id', $quantityType->id)->first();
            if (is_null($drug)) {
                $drug = new Drug();
                $drug->name = $request->drugName;
                $drug->manufacturer = "N/A";
                $drug->quantityType()->associate($quantityType);
                $drug->creator()->associate($user);
                $clinic->drugs()->save($drug);
            }
        }
        return $drug;
    }
}
