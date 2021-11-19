<?php

namespace App\Http\Controllers\Paneles;

use App\Http\Controllers\Controller;
use App\Models\Instituciones\Institucion;
use App\Models\Roles\RolUser;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PanelController extends Controller
{
    public function mostrarInicio()
    {
        if (Auth::user()->institucion) {
            $institucion = Institucion::where('user_id', Auth::id())
                ->first();
            return redirect(route('panel.mostrarRoles', $institucion->id));
        }
        return Inertia::render('Paneles/Inicio/InicioPersona', [
            'roles' => RolUser::where('user_id', Auth::id())
                ->with([
                    'rol:id,institucion_id,nombre',
                    'rol.institucion:id,nombre',
                ])->get(),
        ]);
    }
}
