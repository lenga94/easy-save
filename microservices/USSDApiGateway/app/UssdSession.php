<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UssdSession extends Model
{
    //Table
    protected $table = 'ussd_sessions';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = true;


    protected $fillable = [
        'session_id',
        'phone_number',
        'payload',
    ];
}
