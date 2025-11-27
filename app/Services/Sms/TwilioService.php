<?php

namespace App\Services\Sms;

use Twilio\Rest\Client;

class TwilioService implements SmsServiceInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(config('sms.drivers.twilio.account_sid'), config('sms.drivers.twilio.auth_token'));
    }

    public function send(string $to, string $message)
    {
        return $this->client->messages->create($to, [
            'from' => config('sms.drivers.twilio.from'),
            'body' => $message,
        ]);
    }
}
