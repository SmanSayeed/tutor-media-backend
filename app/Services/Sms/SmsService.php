<?php

namespace App\Services\Sms;

class SmsService implements SmsInterface
{
    private $sms_driver;

    public function __construct()
    {
        $this->setSmsDriver();
    }

    public function send(string $to, string $message)
    {

        $driver_class = $this->getSmsDriver();

        $class_instance = new $driver_class;

        // send sms
        $class_instance->send($to, $message);
    }

    private function setSmsDriver()
    {
        $this->sms_driver = config('sms.default');
    }

    private function getSmsDriver()
    {

        $drivers = config('sms.drivers');

        if (! array_key_exists($this->sms_driver, $drivers)) {
            return null;
        }

        if (! class_exists($drivers[$this->sms_driver]['driver_class'])) {
            return null;
        }

        return new $drivers[$this->sms_driver]['driver_class'];

    }
}
