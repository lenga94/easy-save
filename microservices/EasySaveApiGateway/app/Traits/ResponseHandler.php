<?php


namespace App\Traits;


trait ResponseHandler
{
    public function getResponse($response)
    {
        return json_decode($response);
    }


    public function getResponseData($response)
    {
        return json_decode($response)->data;
    }

    public function getResponseCode($response)
    {
        return json_decode($response)->code;
    }

    public function getResponseError($response)
    {
        return json_decode($response)->error;
    }
}
