<?php

namespace App\Observers\Entregas;

use App\Mail\Entregas\EntregaCalificada as EntregasEntregaCalificada;
use App\Models\Entregas\Entrega;
use App\Models\Materias\AlumnoMateria;
use App\Notifications\Entregas\EntregaCalificada;
use Illuminate\Support\Facades\Mail;

class EntregaObserver
{
    /* public function created(Entrega $entrega)
    {
    } */

    public function updated(Entrega $entrega)
    {
        $alumno = AlumnoMateria::with('rolUser:id,user_id', 'rolUser.user:id,email')
            ->findOrFail($entrega->alumno_materia_id);

        $entregaInfo = $entrega->obtenerInformacionParaLaNotificacion($entrega->id);

        Mail::to($alumno->rolUser->user->email)->queue(new EntregasEntregaCalificada($entrega));

        $alumno->rolUser->user->notify(new EntregaCalificada($entregaInfo));
    }

    /*public function deleted(Entrega $entrega)
    {
    }

    public function restored(Entrega $entrega)
    {
    }

    public function forceDeleted(Entrega $entrega)
    {
    } */
}
