<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    /*
     * Routes that require to be authenticated
     */
    Route::group(['middleware' => 'auth'], function () {

        /*
         * Dashboard
         * The data required for the dashboard will be returned from this function
         */
        Route::get('/', ['as' => 'root', 'uses' => function () {
            $clinic = \App\Clinic::getCurrentClinic();
            $prescriptions = \App\Prescription::whereIn('patient_id', $clinic->patients()->lists('id'));

            $prescriptionCount = $prescriptions->where('issued', 1)->count();
            $payments = \App\Payment::whereIn('prescription_id',
                $prescriptions->where('issued', 1)->lists('id'))->sum('amount');

            return view('dashboard', ['clinic' => $clinic, 'prescriptionCount' => $prescriptionCount,
                'payments' => $payments]);
        }]);


        Route::get('search',['as'=>'search','uses'=>'UtilityController@search']);


        /*
         * Issue Medicine Routes
         */
        Route::get('issueMedicine',
            ['as' => 'issueMedicine', 'uses' => 'PrescriptionController@viewIssueMedicine']);

        /*
         * Routes that manage all the content of patients
         */
        Route::group(['prefix' => 'patients'], function () {
            Route::get('/', ['as' => 'patients', 'uses' => 'PatientController@getPatientList']);

            /*
             * Patients
             */
            Route::post('addPatient', ['as' => 'addPatient', 'uses' => 'PatientController@addPatient']);
            Route::get('patient/{id}', ['as' => 'patient', 'uses' => 'PatientController@getPatient']);
            Route::any('deletePatient/{id}', ['as' => 'deletePatient', 'uses' => 'PatientController@deletePatient']);
            Route::post('editPatient/{id}', ['as' => 'editPatient', 'uses' => 'PatientController@editPatient']);
        });

        /*
         * Routes to manage all the content of drugs
         */
        Route::group(['prefix' => 'drugs'], function () {
            Route::get('/', ['as' => 'drugs', 'uses' => 'DrugController@getDrugList']);

            /*
             * Drugs
             */
            Route::get('drug/{id}', ['as' => 'drug', 'uses' => 'DrugController@getDrug']);
            Route::post('addDrug', ['as' => 'addDrug', 'uses' => 'DrugController@addDrug']);
            Route::post('deleteDrug/{id}', ['as' => 'deleteDrug', 'uses' => 'DrugController@deleteDrug']);
            Route::post('editDrug/{id}', ['as' => 'editDrug', 'uses' => 'DrugController@editDrug']);


            /*
             * Stocks
             */
            Route::post('addStock/{drugId}', ['as' => 'addStock', 'uses' => 'StockController@addStock']);

            /*
             * Drug types
             */
            Route::get('drugTypes', ['as' => 'drugTypes', 'uses' => 'DrugTypeController@getDrugTypeList']);
            Route::post('addDrugType', ['as' => 'addDrugType', 'uses' => 'DrugTypeController@addDrugType']);
            Route::post('deleteDrugType/{id}', ['as' => 'deleteDrugType', 'uses' => 'DrugTypeController@deleteDrugType']);

            /*
             * Dosages
             */
            Route::get('dosages', ['as' => 'dosages', 'uses' => 'DosageController@getDosageList']);
            Route::post('addDosage', ['as' => 'addDosage', 'uses' => 'DosageController@addDosage']);
            Route::post('addFrequency', ['as' => 'addFrequency', 'uses' => 'DosageController@addFrequency']);
            Route::post('addPeriod', ['as' => 'addPeriod', 'uses' => 'DosageController@addPeriod']);

            Route::get('deleteDosage/{id}', ['as' => 'deleteDosage', 'uses' => 'DosageController@deleteDosage']);
            Route::get('deleteFrequency/{id}', ['as' => 'deleteFrequency', 'uses' => 'DosageController@deleteFrequency']);
            Route::get('deletePeriod/{id}', ['as' => 'deletePeriod', 'uses' => 'DosageController@deletePeriod']);
        });


        /*
         * API
         * Routes to manage the internal API for AJAX calls
         */
        Route::group(['prefix' => 'API'], function () {
            Route::post('drugs', 'APIController@getDrugs');
            Route::post('dosages', 'APIController@getDosages');
            Route::post('savePrescription', 'APIController@savePrescription');

            //getting prescriptions
            Route::post('getPrescriptions/{id}', 'APIController@getPrescriptions');
            Route::post('getAllPrescriptions', 'APIController@getAllRemainingPrescriptions');

            Route::post('issuePrescription', 'APIController@issuePrescription');
            Route::post('getPrescriptions/{id}', 'APIController@getPrescriptions');
            Route::post('deletePrescription/{id}', 'APIController@deletePrescription');
            Route::post('getMedicalRecords/{patientId}', 'APIController@getMedicalRecords');
        });
    });

});


