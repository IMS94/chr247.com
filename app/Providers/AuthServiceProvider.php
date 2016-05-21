<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Patient' => 'App\Policies\PatientPolicy',
        'App\Drug' => 'App\Policies\DrugPolicy',
        'App\DrugType' => 'App\Policies\DrugTypePolicy',
        'App\Stock' => 'App\Policies\StockPolicy',
        'App\Dosage' => 'App\Policies\DosagePolicy',
        'App\DosageFrequency' => 'App\Policies\DosagePolicy',
        'App\DosagePeriod' => 'App\Policies\DosagePolicy',
        'App\Prescription' => 'App\Policies\PrescriptionPolicy',
        'App\Queue' => 'App\Policies\QueuePolicy',
        'App\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
