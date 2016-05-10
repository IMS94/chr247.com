<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrugType extends Model
{
    protected $table = "drug_types";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'drug_type', 'created_by', 'clinic_id',
    ];


    /**
     * Get the clinic of the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo('App\Clinic', 'clinic_id', 'id');
    }


    /**
     * Get the user who created the drug type
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
