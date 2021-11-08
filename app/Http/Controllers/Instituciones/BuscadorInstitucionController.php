<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Models\Instituciones\Institucion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BuscadorInstitucionController extends Controller
{
    public function mostrarBuscador(Request $request)
    {
        return Inertia::render('Instituciones/Buscador', [
            'instituciones' => $this->obtenerInstituciones($request),
        ]);
    }

    public function filtrarInstituciones(Request $request)
    {
        return $this->obtenerInstituciones($request);
    }

    public function obtenerInstituciones($request)
    {
        return Institucion::when($request->nombre, function ($query, $nombre) {
                $query->where('nombre', 'LIKE', '%'.$nombre.'%');
            })
            ->orderBy('nombre')
            ->paginate(10);
    }
}
