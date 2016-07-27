<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Drug;
use App\Stock;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller {

    /**
     * Adds a stock to a given drug
     * @param $id
     * @param Request $request
     * @return $this
     */
    public function addStock($id, Request $request) {
        /*
         * In order to add a stock under a given drug, the user role must have permissions to add a drug.
         * Then the drug must be in the same clinic as the user
         */
        $this->authorize('add', 'App\Stock');
        $drug = Drug::find($id);
        $this->authorize('addStocks', $drug);

        $validator = Validator::make($request->all(), [
            'quantity'         => 'required|numeric',
            'manufacturedDate' => 'required|date|before:' . date('Y-m-d') . '|after:' . date('Y-m-d', strtotime('1900-01-01')),
            'receivedDate'     => 'required|date|before:' . date('Y-m-d', time() + 3600 * 24) . '|after:' . $request->manufacturedDate,
            'expiryDate'       => 'required|date|after:' . date('Y-m-d'),
        ]);
        if ($validator->fails()) {
            return back()->with('type', 'stock')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $stock = new Stock();
            $stock->drug()->associate($drug);
            $stock->manufactured_date = $request->manufacturedDate;
            $stock->received_date = $request->receivedDate;
            $stock->expiry_date = $request->expiryDate;
            $stock->quantity = $request->quantity;
            $stock->remarks = $request->remarks;
            $stock->creator()->associate(User::getCurrentUser());
            $stock->save();

            $drug->quantity = $drug->quantity + $request->quantity;
            $drug->update();
        } catch (\Exception $e) {
            DB::rollback();
            $validator->getMessageBag()->add('general ', 'Stock cannot be added. Stock data is incorrect.');
            return back()->with('type', 'stock')->withInput()->withErrors($validator);
        }
        DB::commit();
        return back()->with('success', "Stock added successfully !");
    }


    /**
     * Get the view with stocks that are running low
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStocksRunningLow() {
        $this->authorize('seeRunningLow', 'App\Stock');
        $clinic = Clinic::getCurrentClinic();
        $drugs = $clinic->drugs()->where('quantity', '<', 100)->get();
        return view('drugs.stocks.runningLow', ['drugs' => $drugs]);
    }
}
