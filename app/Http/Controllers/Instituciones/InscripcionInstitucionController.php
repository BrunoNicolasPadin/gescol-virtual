<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instituciones\StoreInscripcionInstitucionRequest;
use App\Models\Instituciones\Institucion;
use App\Models\Roles\Rol;
use App\Models\Roles\RolUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InscripcionInstitucionController extends Controller
{
    public function create($institucion_id)
    {
        return Inertia::render('Instituciones/Inscripciones/Create', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
            'roles' => Rol::where('institucion_id', $institucion_id)->orderBy('nombre')->get(),
        ]);
    }

    public function store(StoreInscripcionInstitucionRequest $request, $institucion_id)
    {
        $rolUser = new RolUser();
        $rolUser->rol()->associate($request->rol_id);
        $rolUser->user()->associate(Auth::id());
        $rolUser->save();

        return redirect()->route('panel.mostrarInicio')
            ->with('message', 'Rol asignado');
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('Instituciones/Inscripciones/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'roles' => Rol::where('institucion_id', $institucion_id)
                ->orderBy('nombre')->get(),
            'inscripcion' => RolUser::findOrFail($id),
        ]);
    }

    public function update(StoreInscripcionInstitucionRequest $request, $institucion_id, $id)
    {
        $rolUser = RolUser::findOrFail($id);
        $rolUser->rol()->associate($request->rol_id);
        $rolUser->save();

        return redirect()->route('panel.mostrarInicio')
            ->with('message', 'Rol actualizado');
    }

    public function destroy($institucion_id, $id)
    {
        RolUser::destroy($id);
        return redirect()->route('panel.mostrarInicio')
            ->with('message', 'Rol eliminado');
    }
}
