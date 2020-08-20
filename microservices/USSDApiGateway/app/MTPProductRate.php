<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MTPProductRate extends Model
{
    //Table
    protected $table = 'mtp_product_rates';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = true;


    protected $fillable = [
        'product_type_id',
        'num_of_quarters',
        'price',
    ];

    public function productType()
    {
        return $this->belongsTo('App\ProductType', 'product_type_id');
    }
}
