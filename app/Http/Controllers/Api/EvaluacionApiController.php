<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evaluaciones\Evaluacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EvaluacionApiController extends Controller
{
    public function obtenerEvaluacionesDeLaMateria($materia_id)
    {
        return Evaluacion::where('materia_id', $materia_id)
            ->orderBy('fechaHoraComienzo', 'ASC')
            ->get()
            ->map(function ($evaluacion) {
                return [
                    'id' => $evaluacion->id,
                    'nombre' => $evaluacion->nombre,
                    'descripcion' => $evaluacion->descripcion,
                    'fechaHoraComienzo' => Carbon::parse($evaluacion->fechaHoraComienzo)->format('d/m/y - H:i:s'),
                    'fechaHoraFinalizacion' => Carbon::parse($evaluacion->fechaHoraFinalizacion)->format('d/m/y - H:i:s'),
                ];
            });
    }

    public function obtenerDetallesDeLaEvaluacion($evaluacion_id)
    {
        $evaluacion = Evaluacion::findOrFail($evaluacion_id);

        return [
            'id' => $evaluacion->id,
            'nombre' => $evaluacion->nombre,
            'descripcion' => $evaluacion->descripcion,
            'fechaHoraComienzo' => Carbon::parse($evaluacion->fechaHoraComienzo)->format('d/m/y - H:i:s'),
            'fechaHoraFinalizacion' => Carbon::parse($evaluacion->fechaHoraFinalizacion)->format('d/m/y - H:i:s'),
        ];
    }
}
