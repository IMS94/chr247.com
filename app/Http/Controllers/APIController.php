<?php

namespace App\Http\Controllers;

use App\Clinic;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;

class APIController extends Controller
{
    /**
     * Get the clinic's drugs
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDrugs()
    {
        $clinic = Clinic::getCurrentClinic();
        $data = $clinic->drugs()->orderBy('name')->select('id', 'name', 'quantity')->get()->toArray();
        return response()->json($data);
    }


    /**
     * Get the Dosages, Frequencies and Periods of the clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDosages()
    {
        $clinic = Clinic::getCurrentClinic();
        $dosages = $clinic->dosages;
        $frequencies = $clinic->dosageFrequencies;
        $periods = $clinic->dosagePeriods;

        return response()->json(['dosages' => $dosages, 'frequencies' => $frequencies, 'periods' => $periods]);
    }
}
