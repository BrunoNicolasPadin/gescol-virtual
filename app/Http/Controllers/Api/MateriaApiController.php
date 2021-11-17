<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Materias\Materia;
use Illuminate\Http\Request;

class MateriaApiController extends Controller
{
    public function obtenerMateriasDelCurso($curso_id)
    {
        return Materia::orderBy('nombre')
            ->where('curso_id', $curso_id)
            ->get();
    }
}
