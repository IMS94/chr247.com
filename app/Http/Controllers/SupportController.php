<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    /**
     * Get the timezones of a country by its country code
     * @param $countryCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTimezones($countryCode)
    {
        $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $countryCode);
        return response()->json($timezones);
    }
}
