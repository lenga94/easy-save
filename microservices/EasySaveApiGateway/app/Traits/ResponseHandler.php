<?php


namespace App\Traits;


trait ResponseHandler
{
    public static function getResponse($response)
    {
        return json_decode($response);
    }

    public static function getResponseData($response)
    {
        return json_decode($response)->data;
    }

    public static function getResponseCode($response)
    {
        return json_decode($response)->code;
    }

    public static function getResponseError($response)
    {
        return json_decode($response)->error;
    }
}
