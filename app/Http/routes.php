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
        Route::get('/', ['as' => 'root', 'uses' => function () {
            return view('dashboard');
        }
        ]);


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


            /*
             * Drug types
             */
            Route::get('drugTypes', ['as' => 'drugTypes', 'uses' => 'DrugTypeController@getDrugTypeList']);
            Route::post('addDrugType', ['as' => 'addDrugType', 'uses' => 'DrugTypeController@addDrugType']);
            Route::post('deleteDrugType/{id}', ['as' => 'deleteDrugType', 'uses' => 'DrugTypeController@deleteDrugType']);
        });
    });

});
