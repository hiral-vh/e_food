<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TotalOrderNotification extends Notification
{
    use Queueable;
    public $notificationDetails;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notificationDetails)
    {
        $this->notificationDetails = $notificationDetails;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /*return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');*/
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($this->notificationDetails['type'] == 1) {
            return [
                'type' => $this->notificationDetails['type'],
                'total_orders' => $this->notificationDetails['total_orders'],
                'message' => $this->notificationDetails['message'],
                'date&time' => $this->notificationDetails['date&time'],
                'url' => $this->notificationDetails['url'],
            ];
        } elseif ($this->notificationDetails['type'] == 2) {
            return [
                'type' => $this->notificationDetails['type'],
                'orderId' => $this->notificationDetails['orderId'],
                'userName' => $this->notificationDetails['userName'],
                'message' => $this->notificationDetails['message'],
                'date&time' => $this->notificationDetails['date&time'],
            ];
        } elseif ($this->notificationDetails['type'] == 4) {
            return [
                'type' => $this->notificationDetails['type'],
                'userName' => $this->notificationDetails['userName'],
                'message' => $this->notificationDetails['message'],
                'tableName' => $this->notificationDetails['tableName'],
                'bookingDate' => $this->notificationDetails['bookingDate'],
            ];
        } else {
            return [
                'type' => $this->notificationDetails['type'],
                'total_orders' => $this->notificationDetails['total_orders'],
                'message' => $this->notificationDetails['message'],
                'date&time' => $this->notificationDetails['date&time'],
            ];
        }
    }
}
