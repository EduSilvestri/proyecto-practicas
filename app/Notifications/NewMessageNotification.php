<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;

    /**
     * Crea una nueva instancia de notificación.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Define los canales de notificación.
     */
    public function via($notifiable)
    {
        // Puedes incluir 'mail', 'database' y 'broadcast' si deseas notificaciones en tiempo real
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Configura el mensaje para el canal de correo.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Nuevo mensaje en el ticket: ' . $this->message->ticket->asunto)
                    ->line('Mensaje: ' . $this->message->content)
                    ->action('Ver Ticket', url(route('tickets.show', $this->message->ticket->id)))
                    ->line('Gracias por utilizar nuestro sistema.');
    }

    /**
     * Configura los datos para almacenar en la base de datos.
     */
    public function toDatabase($notifiable)
    {
        return [
            'ticket_id'   => $this->message->ticket->id,
            'message_id'  => $this->message->id,
            'content'     => $this->message->content,
            'sender'      => $this->message->user->name,
        ];
    }

}

