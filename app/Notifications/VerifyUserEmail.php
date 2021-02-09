<?php
namespace App\Notifications;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class VerifyUserEmail extends Notification
{
    use Queueable;
    protected $pageUrl;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->pageUrl = 'http://'.env('SANCTUM_STATEFUL_DOMAINS').'/verify/';
     }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //$url = url('/reset-password', $this->token);
        $url = $this->pageUrl.$notifiable->getKey();
        return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $url);
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}







/*VerifyEmailBase
{

protected function verificationUrl($notifiable)
{
    return 'http://'.env('SANCTUM_STATEFUL_DOMAINS').'/reset-password/';
    /*return URL::temporarySignedRoute(
    'verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]
    );
}
} */