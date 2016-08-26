<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class SupportController extends Controller {
    /**
     * Get the timezones of a country by its country code
     * @param $countryCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTimezones($countryCode) {
        $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $countryCode);
        return response()->json($timezones);
    }


    /**
     * Get the matching drugs based on a keyword
     *
     * @param $text
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDrugPredictions($text) {
        $drugs = \DB::table('drug_pool')->where('trade_name', 'LIKE', $text . "%")->select('trade_name')
            ->distinct()->take(10)->get();
        return response()->json(['status' => 1, 'drugs' => $drugs]);
    }

    /**
     * Get a list of manufacturers based on a keyword
     *
     * @param $text
     * @return \Illuminate\Http\JsonResponse
     */
    public function getManufacturerPredictions($text) {
        $manufacturers = \DB::table('drug_pool')->where('manufacturer', 'LIKE', $text . "%")
            ->select('manufacturer')->distinct()->take(10)->get();
        return response()->json(['status' => 1, 'manufacturers' => $manufacturers]);
    }

    /**
     * Get the diease name predictions based on a partially entered text
     *
     * @param $text
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDiseasePredictions($text) {
        $diseases = \DB::table('disease_pool')->where('disease', 'LIKE', $text . "%")->select('disease')
            ->take(10)->get();
        return response()->json(['status' => 1, 'diseases' => $diseases]);
    }
}
