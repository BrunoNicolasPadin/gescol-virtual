<?php

namespace App\Notifications\Entregas;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EntregaCalificada extends Notification
{
    use Queueable;

    public function __construct($entrega)
    {
        $this->entrega = $entrega;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'institucion_id' => $this->entrega->institucion_id,
            'curso_id' => $this->entrega->curso_id,
            'materia_id' => $this->entrega->materia_id,
            'materia' => $this->entrega->materia,
            'evaluacion_id' => $this->entrega->evaluacion_id,
            'evaluacion' => $this->entrega->evaluacion,
            'id' => $this->entrega->id,
            'calificacion' => $this->entrega->calificacion,
        ];
    }
}
