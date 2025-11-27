<?php

namespace App\Providers;

use App\Services\Sms\SmsInterface;
use App\Services\Sms\SmsService;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SmsInterface::class, SmsService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            $driver = config('sms.drivers.twilio');
            if (empty($driver)) {
                return;
            }
            config()->set('sms.default', $driver['driver']);
            switch ($driver['driver']) {
                case 'twilio':
                    config()->set('sms.drivers.twilio.account_sid', $driver['account_sid']);
                    config()->set('sms.drivers.twilio.auth_token', $driver['auth_token']);
                    config()->set('sms.drivers.twilio.from', $driver['from']);
                    break;
                case 'nexmo':
                    config()->set('sms.drivers.nexmo.api_key', $driver['api_key']);
                    config()->set('sms.drivers.nexmo.api_secret', $driver['api_secret']);
                    config()->set('sms.drivers.nexmo.from', $driver['from']);
                    break;
            }

        } catch (\Throwable $th) {
            // throw $th;
        }
    }
}
