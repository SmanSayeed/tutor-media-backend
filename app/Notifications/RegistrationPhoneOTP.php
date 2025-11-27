<?php

namespace App\Notifications;

use App\Broadcasting\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RegistrationPhoneOTP extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $otp) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if (! $notifiable->phone) {
            return [];
        }

        return [SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toSMS(object $notifiable): array
    {
        return [
            'subject' => __('OTP Code'),
            'message' => __('Your OTP code is: '.$this->otp).'\n'.__('The code will expire in '.config('application_info.otp.expire_time').' minutes.'),
        ];
    }
}
