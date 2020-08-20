<?php

return [
    'picz_api_gateway' => [
        'base_uri' => env('PICZ_API_GATEWAY_BASE_URL'),
    ],

    'clients' => [
      'base_uri' => env('CLIENTS_SERVICE_BASE_URL'),
      'secret' => env('CLIENTS_SERVICE_SECRET'),
    ],
];
