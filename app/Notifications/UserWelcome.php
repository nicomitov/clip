<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserWelcome extends Notification
{
    use Queueable;

    protected $user;
    protected $plainPassword;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $plainPassword)
    {
        $this->user = $user;
        $this->passwd = $plainPassword;
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
        $verification_url = URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name') . '!')
            ->markdown('emails.user-welcome', [
                'verification_url' => $verification_url,
                'email' => $this->user->email,
                'password' => $this->passwd,
            ]);
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
