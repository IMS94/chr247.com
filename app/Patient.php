<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'dob', 'address', 'created_by', 'clinic_id',
    ];


    /**
     * Clinic of the patient
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo('App\Clinic');
    }

    /**
     * The user who created the patient
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }


    /**
     * Prescriptions of the patient
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prescriptions()
    {
        return $this->hasMany('App\Prescription', 'patient_id', 'id');
    }


    /**
     * Get the queues of this patient
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function queues()
    {
        return $this->belongsToMany('App\Queue', 'queue_patients', 'patient_id', 'queue_id')->withTimestamps();
    }
}
