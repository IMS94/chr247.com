<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table="stocks";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'received_date','expiry_date','manufactured_date','quantity','remarks'
    ];



    /**
     * Get the drug of the given stock
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function drug(){
        return $this->belongsTo('App\Drug','drug_id','id');
    }

    /**
     * Get the user who created the stock
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
