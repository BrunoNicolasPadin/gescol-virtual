<?php

namespace App\Observers\Evaluaciones;

use App\Models\Entregas\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Materias\AlumnoMateria;

class EvaluacionObserver
{
    /**
     * Handle the Evaluacion "created" event.
     *
     * @param  \App\Models\Evaluaciones\Evaluacion  $evaluacion
     * @return void
     */
    public function created(Evaluacion $evaluacion)
    {
        $alumnos = AlumnoMateria::where('materia_id', $evaluacion->materia_id)->get();
        foreach ($alumnos as $alumno) {
            $entrega = new Entrega();
            $entrega->alumnoMateria()->associate($alumno->id);
            $entrega->evaluacion()->associate($evaluacion->id);
            $entrega->save();
        }
    }

    /**
     * Handle the Evaluacion "updated" event.
     *
     * @param  \App\Models\Evaluaciones\Evaluacion  $evaluacion
     * @return void
     */
    public function updated(Evaluacion $evaluacion)
    {
        //
    }

    /**
     * Handle the Evaluacion "deleted" event.
     *
     * @param  \App\Models\Evaluaciones\Evaluacion  $evaluacion
     * @return void
     */
    public function deleted(Evaluacion $evaluacion)
    {
        //
    }

    /**
     * Handle the Evaluacion "restored" event.
     *
     * @param  \App\Models\Evaluaciones\Evaluacion  $evaluacion
     * @return void
     */
    public function restored(Evaluacion $evaluacion)
    {
        //
    }

    /**
     * Handle the Evaluacion "force deleted" event.
     *
     * @param  \App\Models\Evaluaciones\Evaluacion  $evaluacion
     * @return void
     */
    public function forceDeleted(Evaluacion $evaluacion)
    {
        //
    }
}
