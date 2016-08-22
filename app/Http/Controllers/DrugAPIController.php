<?php

namespace App\Http\Controllers;

use App\Clinic;

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

}
