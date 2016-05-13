<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table="payments";

    /**
     * Get the prescription of the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prescription()
    {
        return $this->belongsTo('App\Prescription', 'prescription_id', 'id');
    }

}
