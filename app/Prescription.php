<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $table = "prescriptions";

    /**
     * Get the user who created the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    /**
     * Get the patient of this prescription
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient', 'patient_id', 'id');
    }

    /**
     * Get the drugs in this prescription.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prescriptionDrugs(){
        return $this->hasMany('App\PrescriptionDrug','prescription_id','id');
    }
}
