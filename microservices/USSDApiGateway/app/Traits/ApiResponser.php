<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;

trait ApiResponser
{
    /**
     * Build success response
     * @param $data
     * @param int $code
     * @param int $headerType
     * @return Response|ResponseFactory
     */
    public function successResponse($data, $code = Response::HTTP_OK, $headerType)
    {
        if($headerType = 1) {
            return response($data, $code)->header('Content-Type', 'application/json');
        } else if($headerType = 2) {
            return response($data, $code)->header('Content-Type', 'text/plain');
        }

    }


    /**
     * Build error response
     * @param string|array $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**
     * Build error message
     * @param string|array $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorMessage($message, $code)
    {
        return response($message, $code)->header('Content-Type', 'application/json');
    }
}
