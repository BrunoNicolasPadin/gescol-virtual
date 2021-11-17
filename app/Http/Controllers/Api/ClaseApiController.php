<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clases\Clase;
use Illuminate\Http\Request;

class ClaseApiController extends Controller
{
    public function obtenerClasesDeLaMateria($materia_id)
    {
        return Clase::where('materia_id', $materia_id)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->map(function ($clase) {
                return [
                    'id' => $clase->id,
                    'nombre' => $clase->nombre,
                    'descripcion' => $clase->descripcion,
                ];
            });
    }

    public function obtenerDetallesDeLaClase($clase_id)
    {
        $clase = Clase::findOrFail($clase_id);

        return [
            'id' => $clase->id,
            'nombre' => $clase->nombre,
            'descripcion' => $clase->descripcion,
        ];
    }
}
