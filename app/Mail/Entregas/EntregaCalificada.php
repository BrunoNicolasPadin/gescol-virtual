<?php

namespace App\Mail\Entregas;

use App\Models\Entregas\Entrega;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EntregaCalificada extends Mailable
{
    use Queueable, SerializesModels;

    protected $entrega;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct(Entrega $entrega)
    {
        $this->entrega = $entrega;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $entrega = $this->entrega->obtenerInformacionParaLaNotificacion($this->entrega->id);

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
