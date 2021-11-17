<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;

class CursoApiController extends Controller
{
    public function obtenerCursosDeLaInstitucion($institucion_id)
    {
        return Curso::orderBy('nombre')
            ->where('institucion_id', $institucion_id)
            ->with('materias')
            ->paginate(10);
    }
}
