<?php

namespace App\Services\Sms;

interface SmsInterface
{
    /**
     * Send SMS to the given number.
     *
     * @return void
     */
    public function send(string $to, string $message);
}
