<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Patient;
use Illuminate\Http\Request;

use App\Http\Requests;

class UtilityController extends Controller {
    /**
     * Search for a patient pr drug based on a query given
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request) {
        $query = $request->q;
        $clinic = Clinic::getCurrentClinic();

        $patients = $clinic->patients()
            ->where(function ($q) use ($query) {
                $q->orWhere('first_name', 'LIKE', $query . '%')
                    ->orWhere('last_name', 'LIKE', $query . '%')
                    ->orWhere('nic', 'LIKE', $query . '%')
                    ->orWhere('id', $query);
            })
            ->take(10)->get();

        $drugs = $clinic->drugs()->where('name', 'LIKE', $query . '%')->take(10)->get();
        return view('utils.search', ['patients' => $patients, 'drugs' => $drugs, 'query' => $query]);
    }
}
