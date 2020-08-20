<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //Table
    protected $table = 'products';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = true;


    protected $fillable = [
        'product_name',
        'product_description',
    ];

    public function productTypes()
    {
        return $this->hasMany('App\ProductType', 'product_id');
    }
}
