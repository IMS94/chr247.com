<?php

namespace App\Http\Controllers;

use App\Http\Requests;

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


    public function getDrugPredictions($text) {
        $drugs = \DB::table('drug_pool')->where('trade_name', 'LIKE', $text . "%")->select('trade_name')->distinct()->get();
        return response()->json(['status' => 1, 'drugs' => $drugs]);
    }

    public function getManufacturerPredictions($text) {
        $manufacturers = \DB::table('drug_pool')->where('manufacturer', 'LIKE', $text . "%")->select('manufacturer')->distinct()->get();
        \Log::info($manufacturers);
        return response()->json(['status' => 1, 'manufacturers' => $manufacturers]);
    }
}
