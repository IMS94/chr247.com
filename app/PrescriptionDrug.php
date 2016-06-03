<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrescriptionDrug extends Model {
    protected $table = "prescription_drugs";

    /**
     * Get the drug of the given stock
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function drug() {
        return $this->belongsTo('App\Drug', 'drug_id', 'id');
    }


    /**
     * Get the prescription of the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prescription() {
        return $this->belongsTo('App\Prescription', 'prescription_id', 'id');
    }

    /**
     * Get the dosage of the drug prescribed
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosage() {
        return $this->belongsTo('App\Dosage', 'dosage_id', 'id');
    }

    public function frequency() {
        return $this->belongsTo('App\DosageFrequency', 'frequency_id', 'id');
    }

    public function period() {
        return $this->belongsTo('App\DosagePeriod', 'period_id', 'id');
    }


}
