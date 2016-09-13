<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Patient;
use App\Prescription;
use Illuminate\Http\Request;

use App\Http\Requests;
use Log;

class PrescriptionController extends Controller {
    /**
     * Get the issue medicine page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewIssueMedicine() {
        $this->authorize('issueMedicine', 'App\Patient');

        return view('prescriptions.issueMedicine');
    }

    /**
     * Get the print preview of a prescription.
     *
     * @param $id
     * @param $prescriptionId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function prescriptionPrintPreview($id, $prescriptionId) {
        $patient      = Patient::find($id);
        $prescription = Prescription::find($prescriptionId);
        $this->authorize('printPrescription', [$prescription, $patient]);

        return view('prescriptions.printPreview', ['patient' => $patient, 'prescription' => $prescription]);
    }

    public function getPayments() {
        $this->authorize('view', 'App\Payment');
        $clinic        = Clinic::getCurrentClinic();
        $prescriptions = $clinic->prescriptions()->with('patient')->orderBy('issued_at', 'desc')->get();

        return view('prescriptions.payments', compact("prescriptions"));
    }

}
