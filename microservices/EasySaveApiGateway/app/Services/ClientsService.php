<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class ClientsService
{
    use ConsumesExternalService;

    //The base uri to consume the clients service
    public $baseUri;

    //The secret to consume the clients service
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.clients.base_uri');
        $this->secret = config('services.clients.secret');
    }

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

}
