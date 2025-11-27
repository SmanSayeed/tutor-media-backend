<?php

namespace App\Providers;

use App\Services\Sms\LogSmsService;
use App\Services\Sms\SmsInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SmsInterface::class, function () {
            return new LogSmsService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
