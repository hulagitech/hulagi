<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentNotification extends Notification
{
    use Queueable;
    public $esewa;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($esewa)
    {
        $this->esewa = $esewa;
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
        return (new MailMessage)
            ->line('Dear user, you are receiving this email because You have Rs.'.$this->esewa['Amount'].' due with Hulagi')
            ->action("Pay Amount",url('esewa/pay', $this->esewa['EsewaToken']))
            ->line("This email is automatically sent from the Server Please Contact Finance Department of Hulagi for more details or clear your due by clicking the Pay button above.");
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
