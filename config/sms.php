<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default SMS Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default sms driver that is used to send all sms
    | messages unless another sms driver is explicitly specified when sending
    | the message. All additional sms drivers can be configured within the
    | "divers" array. Examples of each type of sms driver are provided.
    |
    */

    'default' => env('SMS_DRIVER', 'twilio'),

    /*
    |--------------------------------------------------------------------------
    | SMS Drivers
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the sms drivers used by your application
    | plus their respective settings. Several examples have been configured
    | for you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of sms "drivers" that can be used
    | when sending an sms message. You may specify which one you're using for
    | your sms drivers below. You may also add additional sms drivers if needed.
    |
    | Supported: "twilio", "nexmo", "log", "array", "database"
    |
    */

    'drivers' => [
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM'),
            'driver_class' => App\Services\Sms\TwilioService::class,
        ],
    ],

    'from' => env('SMS_FROM'),
];
