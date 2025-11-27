<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Log;

class LogSmsService implements SmsInterface
{
    public function send(string $phone, string $message): void
    {
        Log::channel('sms')->info('SMS SENT', [
            'to' => $phone,
            'message' => $message,
            'sent_at' => now()->toDateTimeString(),
        ]);
    }
}
