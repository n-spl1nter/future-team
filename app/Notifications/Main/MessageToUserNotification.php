<?php

namespace App\Notifications\Main;

use App\Entities\EmailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageToUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $emailMessage;

    /**
     * Create a new notification instance.
     *
     * @param EmailMessage $emailMessage
     */
    public function __construct(EmailMessage $emailMessage)
    {
        $this->emailMessage = $emailMessage;
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
                    ->subject('New message on Future Team')
                    ->view('mail.message-from-user', [
                        'text' => $this->emailMessage->message,
                        'mailFrom' => $this->emailMessage->userFrom->email,
                        'mailFromName' => $this->emailMessage->userFrom->getFullName(),
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
