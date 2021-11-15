<?php

namespace App\Observers\Evaluaciones;

use App\Models\Entregas\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Materias\AlumnoMateria;
use App\Notifications\Evaluaciones\EvaluacionCreada;

class EvaluacionObserver
{
    public function created(Evaluacion $evaluacion)
    {
        $alumnos = AlumnoMateria::where('materia_id', $evaluacion->materia_id)
            ->with('rolUser:id,user_id', 'rolUser.user:id')
            ->get();

        $evaluacionInfo = $evaluacion->obtenerInformacionParaLaNotificacion($evaluacion->id);

        foreach ($alumnos as $alumno) {
            $entrega = new Entrega();
            $entrega->alumnoMateria()->associate($alumno->id);
            $entrega->evaluacion()->associate($evaluacion->id);
            $entrega->save();

            $alumno->rolUser->user->notify(new EvaluacionCreada($evaluacionInfo));
        }
    }
/* 
    public function updated(Evaluacion $evaluacion)
    {
    }

    public function deleted(Evaluacion $evaluacion)
    {
    }

    public function restored(Evaluacion $evaluacion)
    {
    }

    public function forceDeleted(Evaluacion $evaluacion)
    {
    } */
}
