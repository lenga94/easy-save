<?php


namespace App\Traits;


trait ResponseHandler
{
    public function getResponse($response)
    {
        return json_decode($response);
    }
}
