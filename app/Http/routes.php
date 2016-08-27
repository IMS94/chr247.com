<?php

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

// TODO Create a logger class
Route::group(['middleware' => 'web'], function () {
    Route::auth();

    /*
     *  Website
     */
    Route::group(['prefix' => 'web'], function () {
        Route::get("aboutUs", 'WebsiteController@getAboutUsPage');
        Route::get("features", 'WebsiteController@getFeaturesPage');
        Route::get("privacyPolicy", 'WebsiteController@getPrivacyPolicyPage');
        Route::get("contactUs", 'WebsiteController@getContactUs');
        Route::post("contactUs", ['as' => 'contactUs', 'uses' => 'WebsiteController@postContactUs']);
    });


    /*
     * Register Clinic and show privacy policy if required.
     */
    Route::get('registerClinic', ['as' => 'registerClinic', 'uses' => 'ClinicController@showRegistrationForm']);
    Route::post('registerClinic', ['as' => 'registerClinic', 'uses' => 'ClinicController@postRegister']);

    /*
     * Dashboard.
     * This controller method will return the dashboard if the user is logged in.
     * Else, it will return the start page.
     */
    Route::get('/', ['as' => 'root', 'uses' => 'UtilityController@getDashboard']);

    /**
     * ==================================================================================
     * Admin Section    -    The section which manage all the clinics and similar functions
     * ==================================================================================
     */
    Route::get("Admin/login", 'Auth\AdminAuthController@getLogin');
    Route::post("Admin/login", 'Auth\AdminAuthController@postLogin');

    /*
     * Auth routes of the admin
     */
    Route::group(['middleware' => 'admin', 'prefix' => 'Admin'], function () {
        Route::get('admin', ['uses' => 'AdminController@index']);
        Route::get('acceptClinic/{id}', ['as' => 'acceptClinic', 'uses' => 'AdminController@acceptClinic']);
        Route::get('deleteClinic/{id}', ['as' => 'deleteClinic', 'uses' => 'AdminController@deleteClinic']);
        Route::get('logout', ['as' => 'adminLogout', 'uses' => 'Auth\AdminAuthController@getLogout']);
    });


    /**
     * =================================================================================
     * Normal User Section  -   Routes for the normal users
     * =================================================================================
     */
    Route::group(['middleware' => 'auth'], function () {
        // Global Search
        Route::get('search', ['as' => 'search', 'uses' => 'UtilityController@search']);

        // Issue Medicine
        Route::get('issueMedicine', ['as' => 'issueMedicine', 'uses' => 'PrescriptionController@viewIssueMedicine']);

        /*
         * SETTINGS
         */
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', ['as' => 'settings', 'uses' => 'SettingsController@viewSettings']);
            Route::post('changePassword', ['as' => 'changePassword', 'uses' => 'SettingsController@changePassword']);
            Route::post('createAccount', ['as' => 'createAccount', 'uses' => 'SettingsController@createAccount']);
            Route::get('deleteAccount/{id}', ['as' => 'deleteAccount', 'uses' => 'SettingsController@deleteAccount']);

            // Routes to compensate the get methods of post requests
            Route::get('changePassword', ['uses' => 'SettingsController@viewSettings']);
            Route::get('createAccount', ['uses' => 'SettingsController@viewSettings']);
        });

        /*
         * QUEUE    :   Routes related to the queue
         */
        Route::group(['prefix' => 'queue'], function () {
            Route::get('/', ['as' => 'queue', 'uses' => 'QueueController@viewQueue']);

            Route::get('addToQueue/{patientId}', ['as' => 'addToQueue', 'uses' => 'QueueController@addToQueue']);
            Route::get('create', ['as' => 'createQueue', 'uses' => 'QueueController@createQueue']);
            Route::get('close', ['as' => 'closeQueue', 'uses' => 'QueueController@closeQueue']);
        });


        /*
         * PATIENTS : Routes that manage all the content of patients
         */
        Route::group(['prefix' => 'patients'], function () {
            Route::get('/', ['as' => 'patients', 'uses' => 'PatientController@getPatientList']);

            /*
             * PATIENTS
             */
            Route::post('addPatient', ['as' => 'addPatient', 'uses' => 'PatientController@addPatient']);
            Route::get('patient/{id}', ['as' => 'patient', 'uses' => 'PatientController@getPatient']);
            Route::any('deletePatient/{id}', ['as' => 'deletePatient', 'uses' => 'PatientController@deletePatient']);
            Route::post('editPatient/{id}', ['as' => 'editPatient', 'uses' => 'PatientController@editPatient']);
            Route::get('patient/{id}/printID', ['as' => 'IDPreview', 'uses' => 'PatientController@getPrintPreview']);
            Route::get('patient/{id}/printPrescription/{prescriptionId}', ['as' => 'printPrescription',
                'uses' => 'PrescriptionController@prescriptionPrintPreview']);
        });

        /*
         * DRUGS : Routes to manage all the content of drugs
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
            Route::get('stocks/runningLow', ['as' => 'stocksRunningLow', 'uses' => 'StockController@getStocksRunningLow']);

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

            Route::post('editDosage/{id}', ['as' => 'editDosage', 'uses' => 'DosageController@editDosage']);
            Route::post('editFrequency/{id}', ['as' => 'editFrequency', 'uses' => 'DosageController@editFrequency']);
            Route::post('editPeriod/{id}', ['as' => 'editPeriod', 'uses' => 'DosageController@editPeriod']);

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


            Route::post('checkStocksAvailability', 'APIController@checkStocksAvailability');
            Route::post('issuePrescription', 'APIController@issuePrescription');
            Route::post('getPrescriptions/{id}', 'APIController@getPrescriptions');
            Route::post('deletePrescription/{id}', 'APIController@deletePrescription');
            Route::post('getMedicalRecords/{patientId}', 'APIController@getMedicalRecords');

            //queue
            Route::post('getQueue', 'APIController@getQueue');
            Route::post('updateQueue', 'APIController@updateQueue');

            //Drug API
            Route::post("getDosages", 'DrugAPIController@getDosages');
            Route::post("getFrequencies", 'DrugAPIController@getFrequencies');
            Route::post("getPeriods", 'DrugAPIController@getPeriods');

            Route::post("getQuantityTypes", 'DrugAPIController@getQuantityTypes');

            Route::post("saveDrugWithDosages", 'DrugAPIController@saveDrugWithDosages');
        });


        /*
         * FEEDBACK
         */
        Route::group(['prefix' => 'feedback'], function () {
            Route::get('/', 'FeedbackController@getFeedbackForm');
            Route::post('/', 'FeedbackController@sendFeedback');
        });
    });

    /*
     * SUPPORT API
     */
    Route::group(['prefix' => 'API'], function () {
        //clinic registration support
        Route::post('support/timezones/{countryCode}', 'SupportController@getTimezones');
        Route::post('support/drugPredictions/{text}', 'SupportController@getDrugPredictions');
        Route::post('support/manufacturerPredictions/{text}', 'SupportController@getManufacturerPredictions');
        Route::post('support/diseasePredictions/{text}', 'SupportController@getDiseasePredictions');
    });
});

