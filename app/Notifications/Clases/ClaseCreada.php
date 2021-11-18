<?php

namespace App\Notifications\Clases;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaseCreada extends Notification
{
    use Queueable;

    public function __construct($clase)
    {
        $this->clase = $clase;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'institucion_id' => $this->clase->institucion_id,
            'curso_id' => $this->clase->curso_id,
            'materia_id' => $this->clase->materia_id,
            'materia' => $this->clase->materia,
            'id' => $this->clase->id,
            'nombre' => $this->clase->nombre,
        ];
    }
}
