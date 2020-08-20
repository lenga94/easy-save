<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Client extends Model
{
    //Table
    protected $table = 'clients';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = true;


    protected $fillable = [
        'user_id',
        'client_number',
        'first_name',
        'last_name',
        'other_names',
        'title',
        'dob',
        'gender',
        'marital_status',
        'nationality',
        'tribe',
        'nrc',
        'birth_place',
        'passport_number',
        'phone_number',
        'residential_address',
        'postal_address',
        'status',
        'profile_photo',
    ];
}
