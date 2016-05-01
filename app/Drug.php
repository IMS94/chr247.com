<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $table="drugs";

    /**
     * Get the clinic of the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic(){
        return $this->belongsTo('App\Clinic','clinic_id','id');
    }
}
