<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RespostaRecursoNotification extends Notification
{
    use Queueable;
    protected $recursoId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($recursoId)
    {
        $this->recursoId = $recursoId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
                    ->line('O seu recurso foi respondido.')
                    ->action('Ir para o site', url('candidaturas'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'icon' => 'ti-comment-alt',
            'action' => '/candidaturas',
            'message' => 'O seu recurso foi respondido.',
            'bg' => 'bg-success',
        ];
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
