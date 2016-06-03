<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrescriptionPharmacyDrug extends Model {
    protected $table = "prescription_pharmacydrugs";

    /**
     * Get the prescription of the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prescription() {
        return $this->belongsTo('App\Prescription', 'prescription_id', 'id');
    }
}
