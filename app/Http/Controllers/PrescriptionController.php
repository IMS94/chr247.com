<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PrescriptionController extends Controller
{
    /**
     * Get the issue medicine page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewIssueMedicine()
    {
        $this->authorize('issueMedicine', 'App\Patient');
        return view('prescriptions.issueMedicine');
    }
}
