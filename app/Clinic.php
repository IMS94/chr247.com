<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Clinic extends Model
{
    protected $table="clinics";

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
     * Get the currently logged in user's clinic
     * @return mixed
     */
    public static function getCurrentClinic(){
        $user=Auth::user();
        return $user->clinic;
    }
}
