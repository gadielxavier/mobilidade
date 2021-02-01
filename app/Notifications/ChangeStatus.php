<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChangeStatus extends Notification
{
    use Queueable;
    protected $inscricaoId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($inscricaoId)
    {
        $this->inscricaoId = $inscricaoId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                    ->line('O Status da sua inscrição foi atualizado.')
                    ->action('Ir para o site', url('candidaturas/detalhes/'.$this->inscricaoId));
    }
    
    public function toDatabase($notifiable)
    {
        return [
            'icon' => 'ti-info-alt  ',
            'action' => 'candidaturas/detalhes/'.$this->inscricaoId,
            'message' => 'Status da inscrição atualizado',
            'bg' => 'bg-warning',
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
