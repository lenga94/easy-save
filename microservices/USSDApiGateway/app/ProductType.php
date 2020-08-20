<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    //Table
    protected $table = 'product_types';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = true;


    protected $fillable = [
        'product_id',
        'product_type_name',
        'product_type_code',
        'product_type_description',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
