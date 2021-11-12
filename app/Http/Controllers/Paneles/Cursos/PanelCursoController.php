<?php

namespace App\Http\Controllers\Paneles\Cursos;

use App\Http\Controllers\Controller;
use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PanelCursoController extends Controller
{
    public function mostrarCursos($institucion_id)
    {
        return Inertia::render('Cursos/Panel', [
            'institucion' => Institucion::findOrFail($institucion_id),
            'cursos' => Curso::where('institucion_id', $institucion_id)
                ->orderBy('nombre')
                ->paginate(10),
        ]);
    }
}
