<?php

namespace App\Notifications\Evaluaciones;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluacionCreada extends Notification
{
    use Queueable;

    public function __construct($evaluacion)
    {
        $this->evaluacion = $evaluacion;
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
            'institucion_id' => $this->evaluacion->institucion_id,
            'curso_id' => $this->evaluacion->curso_id,
            'materia_id' => $this->evaluacion->materia_id,
            'materia' => $this->evaluacion->materia,
            'id' => $this->evaluacion->id,
            'nombre' => $this->evaluacion->nombre,
            'comienzo' => Carbon::parse($this->evaluacion->fechaHoraComienzo)->format('d/m/y - H:i:s'),
            'finalizacion' => Carbon::parse($this->evaluacion->fechaHoraFinalizacion)->format('d/m/y - H:i:s'),
        ];
    }
}
