<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail as ApiVerifyEmail;
use Illuminate\Bus\Queueable;

class VerifyEmailNotification extends ApiVerifyEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
       //
    }

    /**
   * Get the verification URL for the given notifiable.
   *
   * @param mixed $notifiable
   * @return string
   */
   protected function verificationUrl($notifiable)
   {
    return URL::temporarySignedRoute('verify.user',
    Carbon::now()->addMinutes(180), ['userId' => $notifiable->getKey()]);
   }
}
