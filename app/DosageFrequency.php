<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DosageFrequency extends Model
{
    protected $table="frequencies";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'created_by', 'clinic_id',
    ];

    /**
     * Get the user who created the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }


    /**
     * Get the clinic of the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo('App\Clinic', 'clinic_id', 'id');
    }
}
