<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Clinic extends Model
{
    protected $table="clinics";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'address', 'phone',
    ];


    /**
     * Users of the clinic
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(){
        return $this->hasMany('App\User','clinic_id','id');
    }

    /**
     * Get the patients of the clinic
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patients(){
        return $this->hasMany('App\Patient');
    }

    /**
     * Drugs of the clinic
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drugs(){
        return $this->hasMany('App\Drug','clinic_id','id');
    }


    /**
     * Drug types of the clinic
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quantityTypes(){
        return $this->hasMany('App\DrugType','clinic_id','id');
    }


    /**
     * Dosages related information of the clinic.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dosages(){
        return $this->hasMany('App\Dosage','clinic_id','id');
    }

    public function dosageFrequencies(){
        return $this->hasMany('App\DosageFrequency','clinic_id','id');
    }

    public function dosagePeriods(){
        return $this->hasMany('App\DosagePeriod','clinic_id','id');
    }






    /**
     * Get the currently logged in user's clinic
     * @return mixed
     */
    public static function getCurrentClinic(){
        $user=Auth::user();
        return $user->clinic;
    }
}
