<?php

namespace App\Http\Controllers;

use App\Services\SMSService;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;

class SMSController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the sms micro service.
     * @var smsService
     */
    public $smsService;

    /**
     * Create a new controller instance.
     * @param SMSService $smsService
     */
    public function __construct(SMSService $smsService)
    {
        $this->smsService = $smsService;
    }


    /**
     * Return the list of sms messages
     * @return Response|ResponseFactory
     */
    public function index()
    {
        return $this->successResponse($this->smsService->obtainSMSMessages());
    }

    /**
     * Send one sms message
     * @param Request $request
     * @return Response|ResponseFactory
     */
    public function sendSMSMessage(Request $request)
    {
        return $this->successResponse($this->smsService->sendSMSMessage($request->all(), Response::HTTP_CREATED));
    }

    /**
     * Obtains and shows one sms message
     * @param $sms
     * @return Response|ResponseFactory
     */
    public function show($sms)
    {
        return $this->successResponse($this->smsService->obtainSMSMessage($sms));
    }

    /**
     * Remove an existing sms message
     * @param $sms
     * @return Response|ResponseFactory
     */
    public function destroy($sms)
    {
        return $this->successResponse($this->smsService->deleteSMSMessage($sms));
    }
}
