<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class PatientController extends Controller
{
    public function index()
    {
        return view('patients.patients');
    }


    /*
     * 'firstName' => 'Kamal',
  'lastName' => 'Silva',
  'dob' => '1111-01-11',
  'gender' => 'Male',
  'address' => 'Gampaha',
  'nic' => '940214041V',
  'phone' => '0717086160',
  'bloodGroup' => 'Don\'t know',
  'allergies' => 'Prawn',
  'familyHistory' => 'Not much',
  'medicalHistory' => 'Yep',
  'postSurgicalHistory' => 'Nope',
  'remarks' => 'Good boy',
     * */
    public function addPatient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'gender' => 'required|in:Male,Female',
            'nic' => 'regex:/[0-9]{9}[vV]/',
            'bloodGroup' => 'required|in:A +,A -,B +,B -,AB +,AB -,O +,O -,null'
        ]);

        if ($validator->fails()) {
            return back()->with('type', 'patient')->withErrors($validator)->withInput();
        }

        $clinic = Auth::user()->clinic;

        /*
         * Checks if the same clinic has a patient in the same nic. If yes, it is notified.
         */
        if (!empty($request->nic) && $clinic->patients()->where('nic', $request->nic)->count() > 0) {
            $validator->getMessageBag()->add('nic', 'A patient with this NIC already exists');
            return back()->with('type', 'patient')->withInput()->withErrors($validator);
        }

        $patient = new Patient();
        $patient->first_name = $request->firstName;
        $patient->last_name = $request->lastName ?: null;
        $patient->dob = $request->dob ?: null;
        $patient->gender = $request->gender;
        $patient->address = $request->address ?: null;
        $patient->nic = $request->nic ?: null;
        $patient->phone = $request->phone ?: null;
        $patient->blood_group = $request->bloodGroup != 'null' ?: null;
        $patient->allergies = $request->allergies ?: null;
        $patient->family_history = $request->familyHistory ?: null;
        $patient->medical_history = $request->medicalHistory ?: null;
        $patient->post_surgical_history = $request->postSurgicalHostory ?: null;
        $patient->remarks = $request->remarks ?: null;

        try {
            $patient->clinic()->associate($clinic);
            $patient->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $validator->getMessageBag()->add('general', 'Unable to save the patient details.');
            return back()->with('type', 'patient')->withInput()->withErrors($validator);
        }

        return back()->with('success', $request->firstName . ' added successfully');
    }
}
