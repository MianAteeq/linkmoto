<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stripe' => [
        'model'  => 'App\Models\User',
        'key'    => env('Publishable_key'),
        'secret' => env('Secret_key'),
    ],

    'dvla' => [
        'api_key' => env('DVLA_API_KEY'),
        'url' => env('DVLA_VES_URL', 'https://driver-vehicle-licensing.api.gov.uk/vehicle-enquiry/v1/vehicles'),
    ],

    'dvsa' => [
        'client_id'     => env('DVSA_CLIENT_ID'),
        'client_secret' => env('DVSA_CLIENT_SECRET'),
        'api_key'       => env('DVSA_API_KEY'),
        'scope'         => env('DVSA_SCOPE'),
        'token_url'     => env('DVSA_TOKEN_URL'),
        'base_url'      => env('DVSA_BASE_URL'),
        'proxy'         => env('DVSA_PROXY', null),
    ],

];
