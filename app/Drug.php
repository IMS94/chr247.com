<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $table = "drugs";

    /**
     * Get the clinic of the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo('App\Clinic', 'clinic_id', 'id');
    }


    /**
     * Quantity type of the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quantityType()
    {
        return $this->belongsTo('App\DrugType', 'drug_type_id', 'id');
    }


    /**
     * Get the user who created the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
