<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function patients(){
        return $this->hasMany('App\Patient');
    }
}
