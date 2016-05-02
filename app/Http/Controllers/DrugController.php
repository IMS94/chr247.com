<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Drug;
use App\DrugType;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DrugController extends Controller
{
    /**
     * Get the view to display all the drugs.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDrugList()
    {
        $clinic = Clinic::getCurrentClinic();
        $drugs = $clinic->drugs;
        return view('drugs.drugs', ['drugs' => $drugs]);
    }


    public function getDrug($id)
    {
        $drug = Drug::find($id);
        $this->authorize('view', $drug);
        return "Ok";
    }


    /**
     * Adds a new drug
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addDrug(Request $request)
    {
        Log::info($request->all());
        $this->authorize('add', 'App\Drug');

        $validator = Validator::make($request->all(), [
            'drugName' => 'required',
            'manufacturer' => 'required',
            'quantityType' => 'required|exists:drug_types,id'
        ]);
        if ($validator->fails()) {
            return back()->with('type', 'drug')->withErrors($validator)->withInput();
        }
        /*
         *  drug name, manufacturer, quantity type is unique per clinic
         *  If not, an error will be thrown.
         */
        try {
            $quantityType = DrugType::find($request->quantityType);
            $drug = new Drug();
            $drug->name = $request->drugName;
            $drug->quantityType()->associate($quantityType);
            $drug->clinic()->associate(Clinic::getCurrentClinic());
            $drug->creator()->associate(User::getCurrentUser());
            $drug->manufacturer = $request->manufacturer;
            $drug->save();
        }
        catch(\Exception $e){
            $validator->getMessageBag()->add('drugName', 'Drug already exists');
            return back()->with('type', 'drug')->withInput()->withErrors($validator);
        }
        return back()->with('success', "Drug added successfully !");
    }


    /**
     * Delete a drug
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDrug($id)
    {
        $drug = Drug::find($id);
        $this->authorize('delete', $drug);

        DB::beginTransaction();
        try {
            $drug->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', "The drug cannot be deleted!");;
        }
        DB::commit();
        return back()->with('success', "The drug successfully deleted!");;
    }
}
