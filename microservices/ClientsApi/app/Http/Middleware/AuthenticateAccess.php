<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticateAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $validSecrets = explode(',', env('ACCEPTED_SECRETS'));

        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, Authorisation, X-Requested-With'
        ];

        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);

        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }

        if(in_array($request->header('Authorisation'), $validSecrets))
        {
            return $response;

        } else {

            abort(Response::HTTP_UNAUTHORIZED);
        }
    }
}
