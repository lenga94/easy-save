<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class ApiGatewayService
{
    use ConsumesExternalService;

    //The base uri to consume the easy save api gateway service
    public $baseUri;

    //The secret to consume the easy save api gateway service
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.easy_save_api_gateway.base_uri');
    }


    /********************************** CLIENT ROUTE FUNCTIONS ******************************************/

    /**
     * Obtain the full list of clients from the clients service
     * @return string
     */
    public function obtainAllClients()
    {
        return $this->performRequest('GET', 'clients');
    }

    /**
     * Create a client from the clients service
     * @param $data
     * @return string
     */
    public function createClient($data)
    {
        return $this->performRequest('POST', 'clients', $data);
    }

    /**
     * Obtain a client from the clients service
     * @param $client
     * @return string
     */
    public function obtainClient($client)
    {
        return $this->performRequest('GET', "clients/{$client}");
    }

    /**
     * Update an instance of client from the clients service
     * @param $client
     * @param $data
     * @return string
     */
    public function updateClient($client, $data)
    {
        return $this->performRequest('PUT', "clients/{$client}", $data);
    }

    /**
     * Delete a client from the clients service
     * @param $client
     * @return string
     */
    public function deleteClient($client)
    {
        return $this->performRequest('DELETE', "clients/{$client}");
    }

    /********************************** SMS ROUTE FUNCTIONS ******************************************/

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
