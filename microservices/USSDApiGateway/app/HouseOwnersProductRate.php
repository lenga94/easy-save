<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseOwnersProductRate extends Model
{
    //Table
    protected $table = 'house_owners_product_rates';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = true;


    protected $fillable = [
        'product_type_id',
        'roof_type',
        'rate',
    ];

    public function productType()
    {
        return $this->belongsTo('App\ProductType', 'product_type_id');
    }
}
