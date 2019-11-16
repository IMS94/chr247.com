<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Patient;
use App\Payment;
use App\Prescription;
use Auth;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;

class UtilityController extends Controller {
    /**
     * Search for a patient pr drug based on a query given
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request) {
        $query  = $request->q;
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


    /**
     * Calculates and returns the dashboard along with the required data.
     * Will return the start page if the user is not logged in.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboard() {
        if (Auth::guest()) {
            return view('website.home');
        }

        $clinic        = Clinic::getCurrentClinic();
        $idList = $clinic->patients()->pluck('id')->toArray();

        $prescriptions = collect();
        $batch_size = 10000;
        foreach (array_chunk($idList, $batch_size) as $idListBatch) {
            $prescriptions = Prescription::whereIn('patient_id', $idListBatch)->get()->toBase()->merge($prescriptions);
        }

        $prescriptionCount = $prescriptions->where('issued', 1)->count();
        $payments          = Payment::whereIn('prescription_id',
           $prescriptions->where('issued', 1)->pluck('id'))->sum('amount');
        $stats = $this->calcClinicStats($clinic);

        return view('dashboard', [
            'clinic'   => $clinic, 
            'prescriptionCount' => $prescriptionCount,
            'payments' => $payments, 
            'stats' => $stats
        ]);
    }

    /**
     * Calculates the statistics of a clinic.
     * In order to calculate stats, at least one patient have to be registered
     *
     * @param $clinic
     * @return array
     */
    private function calcClinicStats($clinic) {
        $stats = [
            'visits' => [
                'm' => [],
                'c' => []
            ]
        ];

        $date       = date('Y-m-d H:i:s', strtotime("-6 months"));
//        $patientIds = $clinic->patients()->lists('id')->toArray();
        $patientIds = [];
        if (count($patientIds) > 0) {
            $patientIds = implode(",", $patientIds);
            $query      = "SELECT MONTH(created_at) AS m,COUNT(*) AS c FROM `prescriptions` WHERE `patient_id`
                    IN (" . $patientIds . ") AND `created_at` > :d GROUP BY MONTH(created_at)";
            $pdo        = DB::connection()->getPdo();
            $statement  = $pdo->prepare($query);
            $statement->bindParam('d', $date, \PDO::PARAM_STR);
            $statement->execute();
            $visits = $statement->fetchAll();

            foreach ($visits as $result) {
                $dateObj                = \DateTime::createFromFormat('!m', $result['m']);
                $stats['visits']['m'][] = $dateObj->format('F');
                $stats['visits']['c'][] = $result['c'];
            }
        }

        return $stats;
    }
}
