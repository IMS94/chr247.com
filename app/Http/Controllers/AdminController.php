<?php

namespace App\Http\Controllers;

use App\Clinic;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller {
    private $guard = "admin";


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
        \DB::beginTransaction();
        try {
            $clinic->update();
            \Mail::send('auth.emails.clinicAccepted', ['clinic' => $clinic], function ($m) use ($clinic) {
                $m->to($clinic->email, $clinic->name)->subject('CHR247.COM - Clinic Accepted');
            });
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
            return back()->with("error", "Unable to accept the clinic");
        }
        \DB::commit();
        return back()->with("success", $clinic->name . " clinic Accepted");
    }

}
