<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserSubscription extends Notification
{
    use Queueable;
    protected $candidaturaId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($candidaturaId)
    {
        $this->candidaturaId = $candidaturaId;
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
        return (new MailMessage)
                    ->line('Nova iscrição de candidato')
                    ->action('Ir para o site', url('editais/detalhes/'.$this->candidaturaId));
    }

    public function toDatabase($notifiable)
    {
        return [
            'icon' => 'ti-user',
            'action' => 'editais/detalhes/candidatura/'.$this->candidaturaId,
            'message' => 'Nova iscrição de candidato',
            'bg' => 'bg-info',
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
