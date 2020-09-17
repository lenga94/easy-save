<?php

namespace App\Http\Controllers;

use App\Services\ClientsService;
use App\Services\SMSService;
use App\Traits\ApiResponser;
use App\Traits\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;

class ClientsController extends Controller
{
    use ApiResponser;
    use ResponseHandler;

    /**
     * The service to consume the clients micro service.
     * @var ClientsService
     */
    public $clientsService;

    /**
     * The service to consume the sms micro service.
     * @var smsService
     */
    public $smsService;

    /**
     * Create a new controller instance.
     * @param ClientsService $clientsService
     * @param SMSService $smsService
     */
    public function __construct(ClientsService $clientsService, SMSService $smsService)
    {
        $this->clientsService = $clientsService;
        $this->smsService = $smsService;
    }


    /**
     * Return the list of all clients
     * @return Response|ResponseFactory
     */
    public function index()
    {
        return $this->successResponse($this->clientsService->obtainAllClients());
    }

    /**
     * Create one new client
     * @param Request $request
     * @return JsonResponse|ResponseFactory
     */
    public function store(Request $request)
    {
        //get phone number from request
        $phoneNumber = $request->phone_number;

        //create client
        $response = $this->clientsService->createClient($request->all());

        if($this->getResponseCode($response) == Response::HTTP_CREATED) {

            //get client from response
            $client = $this->getResponseData($response);

            //send sms to client phone number
            $this->smsService->sendSMSMessage(array (
                "phone_number" => $phoneNumber,
                "message_body" => "Thank you {$client->first_name} for using Easy Save. Your have been successfully registered to use easy save services. Your reference number is {$client->client_number}"
            ));

            return $this->successResponse($response, $this->getResponseCode($response));
        }

        return $this->errorResponse($this->getResponseError($response), $this->getResponseCode($response));
    }

    /**
     * Obtains and shows one client
     * @param $client
     * @return Response|ResponseFactory
     */
    public function show($client)
    {
        return $this->successResponse($this->clientsService->obtainClient($client));
    }

    /**
     * Update an existing client
     * @param Request $request
     * @param $client
     * @return Response|ResponseFactory
     */
    public function update(Request $request, $client)
    {
        return $this->successResponse($this->clientsService->updateClient($client, $request->all()));
    }

    /**
     * Remove an existing client
     * @param $client
     * @return Response|ResponseFactory
     */
    public function destroy($client)
    {
        return $this->successResponse($this->clientsService->deleteClient($client));
    }
}
