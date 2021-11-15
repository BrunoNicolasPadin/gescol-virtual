<?php

namespace App\Observers\Entregas;

use App\Models\Entregas\Entrega;
use App\Models\Materias\AlumnoMateria;
use App\Notifications\Entregas\EntregaCalificada;

class EntregaObserver
{
    /* public function created(Entrega $entrega)
    {
    } */

    public function updated(Entrega $entrega)
    {
        $alumno = AlumnoMateria::with('rolUser:id,user_id', 'rolUser.user:id')
            ->findOrFail($entrega->alumno_materia_id);

        $entregaInfo = $entrega->obtenerInformacionParaLaNotificacion($entrega->id);

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
