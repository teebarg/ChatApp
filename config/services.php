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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // 'google' => [
    //     'client_id' => '845839971634-fir8j8g2shm4u71jr8rb1rsuj38egju3.apps.googleusercontent.com',
    //     'client_secret' => 'DBgTesP3uZN9Uk1DSH7i4q_T',
    //     'redirect' => 'http://your-callback-url'
    // ],

    'google' => [
        'client_id' => '845839971634-ja4hmqmto01f6bq6d9dsgjscn6gdep18.apps.googleusercontent.com',
        'client_secret' => 'Y20NHQCyUd52GQPskwU7Y-GN',
        'redirect' => 'http://your-callback-url'
    ],

    'facebook' => [
        'client_id' => '2406324666362534',
        'client_secret' => 'f69430ca5b3650b31833048d110f9714',
        'redirect' => 'http://your-callback-url'
    ],

];
