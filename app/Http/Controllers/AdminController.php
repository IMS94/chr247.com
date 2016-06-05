<?php

namespace App\Http\Controllers;

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
            return view("admin.acceptClinics");
        }
        return view("admin.adminLogin");
    }
}
