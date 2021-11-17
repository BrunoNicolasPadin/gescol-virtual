<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instituciones\StoreInscripcionInstitucionRequest;
use App\Models\Instituciones\Institucion;
use App\Models\Roles\Rol;
use App\Models\Roles\RolUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class InscripcionInstitucionController extends Controller
{
    public function create($institucion_id)
    {
        $this->authorize('create', [RolUser::class, $institucion_id]);

        return Inertia::render('Instituciones/Inscripciones/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'roles' => Rol::where('institucion_id', $institucion_id)
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    public function store(
        StoreInscripcionInstitucionRequest $request,
        $institucion_id
    ) {
        $this->authorize('create', [RolUser::class, $institucion_id]);

        $rol = Rol::findOrFail($request->rol_id);

        if (Hash::check($request->claveDeAcceso, $rol->claveDeAcceso)) {
            $rolUser = new RolUser();
            $rolUser->rol()->associate($request->rol_id);
            $rolUser->user()->associate(Auth::id());
            $rolUser->save();

            return redirect()->route('panel.mostrarInicio')
                ->with('message', 'Rol asignado');
        }
        return redirect()->back()
            ->with('message', 'Clave de acceso incorrecta');
    }

    public function edit($institucion_id, RolUser $inscripcione)
    {
        $this->authorize('update', $inscripcione);

        return Inertia::render('Instituciones/Inscripciones/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'roles' => Rol::where('institucion_id', $institucion_id)
                ->orderBy('nombre')->get(),
            'inscripcion' => $inscripcione,
        ]);
    }

    public function update(
        StoreInscripcionInstitucionRequest $request,
        $institucion_id,
        RolUser $inscripcione
    ) {
        $this->authorize('update', $inscripcione);

        $rol = Rol::findOrFail($request->rol_id);

        if (Hash::check($request->claveDeAcceso, $rol->claveDeAcceso)) {
            $inscripcione->rol()->associate($request->rol_id);
            $inscripcione->save();

            return redirect()->route('panel.mostrarInicio')
                ->with('message', 'Rol cambiado');
        }
        return redirect()->back()
            ->with('message', 'Clave de acceso incorrecta');
    }

    public function destroy($institucion_id, RolUser $inscripcione)
    {
        $this->authorize('delete', $inscripcione);

        $inscripcione->delete();

        return redirect()->route('panel.mostrarInicio')
            ->with('message', 'Rol eliminado');
    }
}
