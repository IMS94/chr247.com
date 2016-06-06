<?php

namespace App\Http\Controllers;

use App\Clinic;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller {
    private $guard = "admin";


    /*public function __construct() {
        $this->middleware('auth:admin');
    }*/


    /**
     * Handles the root url under Admin route group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        if (\Auth::guard($this->guard)->check()) {
            $clinics = Clinic::where('accepted', false)->get();
            return view("admin.acceptClinics", ['clinics' => $clinics]);
        }
        return view("admin.adminLogin");
    }

    /**
     * Accepts a clinic
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptClinic($id) {
        $clinic = Clinic::find($id);
        $clinic->accepted = true;
        $clinic->update();

        return back()->with("success", $clinic->name . " clinic Accepted");
    }

}
