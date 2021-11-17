<?php

namespace App\Mail\Entregas;

use App\Models\Entregas\Entrega;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EntregaCalificada extends Mailable
{
    use Queueable, SerializesModels;

    protected $entrega;

    public function __construct(Entrega $entrega)
    {
        $this->entrega = $entrega;
    }

    public function build()
    {
        $entrega = $this->entrega->obtenerInformacionParaLaNotificacion(
            $this->entrega->id
        );

        return $this->from('gescol@gmail.com', 'Gescol')
            ->subject('Entrega calificada')
            ->view('emails.entregaCalificada')
            ->with([
                'evaluacion' => $entrega->evaluacion,
                'materia' => $entrega->materia,
                'calificacion' => $entrega->calificacion,
            ]);
    }
}
