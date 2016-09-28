<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Drug;
use App\DrugType;
use App\Lib\Logger;
use App\Stock;
use App\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Validator;

class DrugController extends Controller {
    /**
     * Get the view to display all the drugs.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDrugList() {
        $clinic = Clinic::getCurrentClinic();
        $drugs  = $clinic->drugs;

        return view('drugs.drugs', ['drugs' => $drugs]);
    }


    /**
     * Get the page to view a single drug
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDrug($id) {
        $drug = Drug::find($id);
        $this->authorize('view', $drug);

        return view('drugs.drug', ['drug' => $drug]);
    }


    /**
     * Adds a new drug
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addDrug(Request $request) {
        $this->authorize('add', 'App\Drug');

        //if the user is adding a stock, then the ability to add stocks will also be checked.
        if (!empty($request->quantity)) {
            $this->authorize('add', 'App\Stock');
            $validator = Validator::make($request->all(), [
                'quantity'         => 'required|numeric',
                'manufacturedDate' => 'required|date|date_format:Y/m/d|before:' . date('Y-m-d') . '|after:' . date('Y-m-d', strtotime('1900-01-01')),
                'receivedDate'     => 'required|date|date_format:Y/m/d|before:' . date('Y-m-d', time() + 3600 * 24) . '|after:' . $request->manufacturedDate,
                'expiryDate'       => 'required|date|date_format:Y/m/d|after:' . date('Y-m-d'),
            ]);
            if ($validator->fails()) {
                Logger::error("Validation failed when adding initial drug quantity.", $validator->errors()->toArray());

                return back()->with('type', 'drug')->withErrors($validator)->withInput();
            }
        }

        $validator = Validator::make($request->all(), [
            'drugName'     => 'required|min:2',
            'ingredient'   => 'required|min:2',
            'manufacturer' => 'required|min:2',
            'quantityType' => 'required|exists:drug_types,id',
        ]);
        if ($validator->fails()) {
            Logger::error("Validation failed when adding a drug", $validator->errors()->toArray());

            return back()->with('type', 'drug')->withErrors($validator)->withInput();
        }

        /*
         *  drug name, manufacturer, quantity type is unique per clinic
         *  If not, an error will be thrown.
         *  Also, the initial stock will be validated if entered.
         */
        DB::beginTransaction();
        try {
            $quantityType     = DrugType::find($request->quantityType);
            $drug             = new Drug();
            $drug->name       = $request->drugName;
            $drug->ingredient = $request->ingredient;
            $drug->quantityType()->associate($quantityType);
            $drug->clinic()->associate(Clinic::getCurrentClinic());
            $drug->creator()->associate(User::getCurrentUser());
            $drug->manufacturer = $request->manufacturer;
            $drug->save();

            //if initial stock is set, update the drug quantity and insert stock
            if (!empty($request->quantity)) {
                $stock = new Stock();
                $stock->drug()->associate($drug);
                $stock->manufactured_date = date('Y-m-d', strtotime($request->manufacturedDate));
                $stock->received_date     = date('Y-m-d', strtotime($request->receivedDate));
                $stock->expiry_date       = date('Y-m-d', strtotime($request->expiryDate));
                $stock->quantity          = $request->quantity;
                $stock->remarks           = $request->remarks;
                $stock->creator()->associate(User::getCurrentUser());
                $stock->save();

                $drug->quantity = $drug->quantity + $request->quantity;
                $drug->update();
            }
        } catch (Exception $e) {
            Logger::error("Failed adding the drug : " . $e->getMessage());
            DB::rollback();
            $validator->getMessageBag()->add('general', 'Drug already exists or Stock data is incorrect');

            return back()->with('type', 'drug')->withInput()->withErrors($validator);
        }
        DB::commit();

        return back()->with('success', "Drug added successfully !");
    }


    /**
     * Delete a drug
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDrug($id) {
        $drug = Drug::find($id);
        $this->authorize('delete', $drug);

        DB::beginTransaction();
        try {
            $drug->delete();
        } catch (Exception $e) {
            DB::rollback();

            return back()->with('error', "The drug cannot be deleted!");;
        }
        DB::commit();

        return back()->with('success', "The drug successfully deleted!");;
    }


    /**
     * Edits a drug
     * @param $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function editDrug($id, Request $request) {
        $drug = Drug::find($id);
        $this->authorize('edit', $drug);

        $validator = Validator::make($request->all(), [
            'drugName'     => 'required',
            'ingredient'   => 'required|min:2',
            'manufacturer' => 'required',
            'quantityType' => 'required|exists:drug_types,id',
        ]);
        if ($validator->fails()) {
            Logger::error("Validation failed when editing drug", $request->all());

            return back()->with('type', 'drug')->withErrors($validator)->withInput();
        }

        /*
         *  drug name, manufacturer, quantity type is unique per clinic
         *  If not, an error will be thrown.
         *  Also, the initial stock will be validated if entered.
         */
        DB::beginTransaction();
        try {
            $quantityType     = DrugType::find($request->quantityType);
            $drug->name       = $request->drugName;
            $drug->ingredient = $request->ingredient;
            $drug->quantityType()->associate($quantityType);
            $drug->manufacturer = $request->manufacturer;
            $drug->update();

        } catch (Exception $e) {
            Logger::error("Exception when editing drug : " . $e->getMessage(), $request->all());
            DB::rollback();
            $validator->getMessageBag()->add('drugName', 'Drug name already exists');

            return back()->withInput()->withErrors($validator);
        }
        DB::commit();

        return back()->with('type', 'drug')->with('success', "Drug updated successfully !");
    }
}
