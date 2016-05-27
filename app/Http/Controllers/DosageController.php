<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Dosage;
use App\DosageFrequency;
use App\DosagePeriod;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DosageController extends Controller
{

    /**
     * Get dosages as a list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDosageList()
    {
        $clinic = Clinic::getCurrentClinic();
        $dosages = $clinic->dosages;
        $frequencies = $clinic->dosageFrequencies;
        $periods = $clinic->dosagePeriods;

        return view('drugs.dosages.dosages',
            ['dosages' => $dosages, 'frequencies' => $frequencies, 'periods' => $periods]
        );
    }


    /**
     * Adds a new Dosage to the system
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addDosage(Request $request)
    {
        $this->authorize('add', 'App\Dosage');

        $validator = Validator::make($request->all(), [
            'dosageDescription' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('type', 'dosage')->withErrors($validator)->withInput();
        }

        //description must be unique per system.
        $clinic = Clinic::getCurrentClinic();
        if ($clinic->dosages()->where('description', $request->dosageDescription)->count() > 0) {
            $validator->getMessageBag()->add('dosageDescription', 'The description already exists');
            return back()->with('type', 'dosage')->withInput()->withErrors($validator);
        }

        try {
            $dosage = new Dosage();
            $dosage->description = $request->dosageDescription;
            $dosage->clinic()->associate($clinic);
            $dosage->creator()->associate(User::getCurrentUser());
            $dosage->save();
        } catch (\Exception $e) {
            $validator->getMessageBag()->add('general', 'Unable to add the dosage');
            return back()->with('type', 'dosage')->withInput()->withErrors($validator);
        }
        return back()->with('success', "Dosage added successfully !");
    }


    /**
     * Adds a new Dosage Frequency to the system
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addFrequency(Request $request)
    {
        $this->authorize('add', 'App\Dosage');

        $validator = Validator::make($request->all(), [
            'frequencyDescription' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('type', 'frequency')->withErrors($validator)->withInput();
        }

        //description must be unique per system.
        $clinic = Clinic::getCurrentClinic();
        if ($clinic->dosageFrequencies()->where('description', $request->frequencyDescription)->count() > 0) {
            $validator->getMessageBag()->add('frequencyDescription', 'The description already exists');
            return back()->with('type', 'frequency')->withInput()->withErrors($validator);
        }

        try {
            $frequency = new DosageFrequency();
            $frequency->description = $request->frequencyDescription;
            $frequency->clinic()->associate($clinic);
            $frequency->creator()->associate(User::getCurrentUser());
            $frequency->save();
        } catch (\Exception $e) {
            $validator->getMessageBag()->add('general', 'Unable to add the dosage frequency');
            return back()->with('type', 'frequency')->withInput()->withErrors($validator);
        }
        return back()->with('success', "Dosage Frequency added successfully !");
    }


    /**
     * Adds a new Dosage Period to the system
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addPeriod(Request $request)
    {
        $this->authorize('add', 'App\Dosage');

        $validator = Validator::make($request->all(), [
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('type', 'period')->withErrors($validator)->withInput();
        }

        //description must be unique per system.
        $clinic = Clinic::getCurrentClinic();
        if ($clinic->dosagePeriods()->where('description', $request->description)->count() > 0) {
            $validator->getMessageBag()->add('description', 'The description already exists');
            return back()->with('type', 'period')->withInput()->withErrors($validator);
        }

        try {
            $period = new DosagePeriod();
            $period->description = $request->description;
            $period->clinic()->associate($clinic);
            $period->creator()->associate(User::getCurrentUser());
            $period->save();
        } catch (\Exception $e) {
            $validator->getMessageBag()->add('general', 'Unable to add the dosage period');
            return back()->with('type', 'period')->withInput()->withErrors($validator);
        }
        return back()->with('success', "Dosage Period added successfully !");
    }


    /**
     * Delete a dosage entry from the database
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDosage($id)
    {
        $dosage = Dosage::find($id);
        $this->authorize('delete', $dosage);
        DB::beginTransaction();
        try {
            $dosage->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'The entry cannot be deleted');
        }
        DB::commit();
        return back()->with('success', 'Entry deleted successfully');
    }


    /**
     * Delete a dosage frequency entry from the database
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFrequency($id)
    {
        $dosage = DosageFrequency::find($id);
        $this->authorize('delete', $dosage);
        DB::beginTransaction();
        try {
            $dosage->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'The entry cannot be deleted');
        }
        DB::commit();
        return back()->with('success', 'Entry deleted successfully');
    }


    /**
     * Delete a period entry from the database
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePeriod($id)
    {
        $dosage = DosagePeriod::find($id);
        $this->authorize('delete', $dosage);
        DB::beginTransaction();
        try {
            $dosage->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'The entry cannot be deleted');
        }
        DB::commit();
        return back()->with('success', 'Entry deleted successfully');
    }
}
