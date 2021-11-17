<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instituciones\Institucion;

class InstitucionApiController extends Controller
{
    public function obtenerTodasLasInstituciones()
    {
        return Institucion::orderBy('nombre')->paginate(10);
    }

    public function buscar($nombre)
    {
        return Institucion::orderBy('nombre')
            ->where('nombre', 'LIKE', '%'.$nombre.'%')
            ->paginate(10);
    }
}
