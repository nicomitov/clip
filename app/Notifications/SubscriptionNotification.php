<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionNotification extends Notification
{
    use Queueable;

    protected $subscription;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $subscription)
    {
        $this->user = $user;
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->notify ? ['mail', 'database'] : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $this->subscription->created_at == $this->subscription->updated_at ? $event = 'Created' : $event = 'Updated';

        return (new MailMessage)
            ->subject($event . ' Subscription')
            ->markdown('emails.subscription', [
                'url' => route('subscriptions.show', $this->subscription),
                'user' => $this->user->name,
                'id' => $this->subscription->id,
                'event' => strtolower($event),
                'client' => $this->subscription->client->name,
                'emails' => implode(",<br>", $this->subscription->emails->pluck('email')->toArray()),
                'type' => $this->subscription->type->display_name,
                'period' => $this->subscription->start_date->format('j M Y') .' - '. $this->subscription->end_date->format('j M Y'),
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
        $this->subscription->created_at == $this->subscription->updated_at ? $event = 'created a new subscription' : $event = 'updated a subscription';

        return [
            'url' => route('subscriptions.show', $this->subscription),
            'user' => $this->user->name,
            'event' => $event,
            'id' => $this->subscription->id,
        ];
    }
}
