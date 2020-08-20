<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class SMSService
{
    use ConsumesExternalService;

    //The base uri to consume the PICZ API gateway
    public $baseUri;

    //The secret to consume the PICZ API gateway
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.picz_api_gateway.base_uri');
    }


    /******************************************** SMS ROUTE FUNCTIONS ***************************************************/

    /**
     * Obtain the full list of sent sms messages from the sms service
     * @return string
     */
    public function obtainSMSMessages()
    {
        return $this->performRequest('GET', 'sms-messages');
    }

    /**
     * Send an sms message from the sms service
     * @param $data
     * @return string
     */
    public function sendSMSMessage($data)
    {
        return $this->performRequest('POST', 'sms-messages/send-sms', $data);
    }

    /**
     * Obtain an sms message from the sms service
     * @param $sms
     * @return string
     */
    public function obtainSMSMessage($sms)
    {
        return $this->performRequest('GET', "sms-messages/{$sms}");
    }

    /**
     * Delete an sms message from the sms service
     * @param $sms
     * @return string
     */
    public function deleteSMSMessage($sms)
    {
        return $this->performRequest('DELETE', "sms-messages/{$sms}");
    }
}
