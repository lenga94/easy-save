<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisteredClient extends Model
{
    //Table
    protected $table = 'registered_clients';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = true;


    protected $fillable = [
        'first_name',
        'last_name',
        'nrc',
        'gender',
        'phone_number',
        'residential_address',
        'status',
    ];
}
