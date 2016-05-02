<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\DrugType;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DrugTypeController extends Controller
{
    /**
     * get the drug types list view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDrugTypeList()
    {
        $clinic = Clinic::getCurrentClinic();
        $drugTypes = $clinic->drugTypes;
        return view('drugs.drugTypes.drugTypes', ['drugTypes' => $drugTypes]);
    }


    /**
     * Adds a new drug type
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addDrugType(Request $request){
        $name=$request->drugType;
        $clinic=Clinic::getCurrentClinic();
        $this->authorize('add','App\DrugType');

        $validator = Validator::make($request->all(), [
            'drugType' => 'required'
        ]);
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }

        try{
            $drugType=new DrugType();
            $drugType->drug_type=$name;
            $drugType->clinic()->associate($clinic);
            $drugType->creator()->associate(User::getCurrentUser());
            $drugType->save();
            return back()->with('success', $request->drugType . ' added successfully');
        }
        catch(\Exception $e){
            $validator->getMessageBag()->add('drugType', 'Drug Type already exists');
            return back()->withInput()->withErrors($validator);
        }
    }

    /**
     * Delete a drug type
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDrugType($id){
        $drugType=DrugType::find($id);
        $this->authorize('delete',$drugType);

        try{
            $drugType->delete();
        }
        catch(\Exception $e){
            return back()->with('error','Unable to delete '.$drugType->drug_type.". It may be associated with Drugs");
        }
        return back()->with('success',$drugType->drug_type." successfully deleted!");
    }
}
