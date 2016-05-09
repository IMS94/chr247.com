<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table='patients';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','dob','address','created_by','clinic_id',
    ];



    /**
     * Clinic of the patient
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic(){
        return $this->belongsTo('App\Clinic');
    }

    /**
     * The user who created the patient
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User','created_by','id');
    }
}
