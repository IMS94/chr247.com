<?php

namespace App\Http\Controllers;

use App\Clinic;
use Illuminate\Http\Request;

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


    public function saveDrugWithDosages(Request $request) {
        \Log::info($request->all());
        $clinic = Clinic::getCurrentClinic();
        $validator = \Validator::make($request->all(), [
            'drug' => 'required_without:drugName|numeric|exists:drug_types,id,clinic_id,' . $clinic->id,
            'drugName' => 'required_without:drug|max:200',
            'quantityType' => 'required_with:drugName|min:2|max:100',
            'dosage' => 'required_without:dosageText|exists:dosages,id,clinic_id,' . $clinic->id,
            'dosageText' => 'required_without:dosage|min:2|max:100',
            'frequency' => 'exists:frequencies,id,clinic_id,' . $clinic->id,
            'frequencyText' => 'min:2|max:100',
            'period' => 'exists:periods,id,clinic_id,' . $clinic->id,
            'periodText' => 'min:2|max:100',
        ]);
        if ($validator->fails()) {
            \Log::error($validator->errors());
            return response()->json($validator->errors());
        }
        return 0;
    }
}
