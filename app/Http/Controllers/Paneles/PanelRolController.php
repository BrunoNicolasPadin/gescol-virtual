<?php

namespace App\Http\Controllers\Paneles;

use App\Http\Controllers\Controller;
use App\Models\Instituciones\Institucion;
use App\Models\Roles\Rol;
use Inertia\Inertia;

class PanelRolController extends Controller
{
    public function mostrarRoles($institucion_id)
    {
        return Inertia::render('Paneles/Roles', [
            'institucion' => Institucion::findOrFail($institucion_id),
            'roles' => Rol::where('institucion_id', $institucion_id)
                ->orderBy('nombre')
                ->get(),
        ]);
    }
}
