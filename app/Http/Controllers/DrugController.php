<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Drug;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DrugController extends Controller
{
    /**
     * Get the view to display all the drugs.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDrugList(){
        $clinic=Clinic::getCurrentClinic();
        $drugs=$clinic->drugs;
        return view('drugs.drugs',['drugs'=>$drugs]);
    }


    public function getDrug($id){
        $drug=Drug::find($id);
        $this->authorize('view',$drug);
        return "Ok";
    }
}
