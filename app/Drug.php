<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $table = "drugs";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'manufacturer', 'quantity', 'drug_type_id', 'created_by', 'clinic_id',
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
     * Quantity type of the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quantityType()
    {
        return $this->belongsTo('App\DrugType', 'drug_type_id', 'id');
    }


    /**
     * Get the quantity type as a string
     * @return String
     */
    public function getQuantityType(){
        return $this->quantityType->drug_type;
    }


    /**
     * Get the user who created the drug
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }


    /**
     * Get the stocks of this drug.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany('App\Stock', 'drug_id', 'id');
    }

    /**
     * Get the most recent 'n' stocks of a drug.
     * @param int $limit
     * @return mixed
     */
    public function getStocks($limit=5){
        return $this->stocks()->orderBy('id','desc')->take($limit)->get();
    }
}
