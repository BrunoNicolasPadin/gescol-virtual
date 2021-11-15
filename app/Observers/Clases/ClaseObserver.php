<?php

namespace App\Observers\Clases;

use App\Models\Clases\Clase;
use App\Models\Materias\AlumnoMateria;
use App\Notifications\Clases\ClaseCreada;

class ClaseObserver
{
    public function created(Clase $clase)
    {
        $alumnos = AlumnoMateria::where('materia_id', $clase->materia_id)
            ->with('rolUser:id,user_id', 'rolUser.user:id')
            ->get();

        $claseInfo = $clase->obtenerInformacionParaLaNotificacion($clase->id);

        foreach ($alumnos as $alumno) {
            $alumno->rolUser->user->notify(new ClaseCreada($claseInfo));
        }
    }

    /* public function updated(Clase $clase)
    {
    }

    public function deleted(Clase $clase)
    {
    }

    public function restored(Clase $clase)
    {
    }

    public function forceDeleted(Clase $clase)
    {
    } */
}
