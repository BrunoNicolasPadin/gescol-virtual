<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRolRequest;
use App\Models\Instituciones\Institucion;
use App\Models\Roles\Rol;
use Inertia\Inertia;

class RolController extends Controller
{
    public function index()
    {
        //
    }

    public function create($institucion_id)
    {
        return Inertia::render('Roles/Create', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
        ]);
    }

    public function store(StoreRolRequest $request, $institucion_id)
    {
        for ($i = 0; $i < count($request->roles); $i++) { 
            $rol = new Rol();
            $rol->nombre = $request->roles[$i]['nombre'];
            $rol->institucion()->associate($institucion_id);
            $rol->save();
        }

        return redirect(route('roles.index', $institucion_id))
            ->with('message', 'Rol/es agregado/s');
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('Roles/Edit', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
            'rol' => Rol::findOrFail($id),
        ]);
    }

    public function update(StoreRolRequest $request, $institucion_id, $id)
    {
        $rol = Rol::findOrFail($id);
        $rol->nombre = $request->nombre;
        $rol->save();

        return redirect(route('roles.index', $institucion_id))
            ->with('message', 'Rol actualizado');
    }

    public function destroy($institucion_id, $id)
    {
        Rol::destroy($id);
        return redirect(route('roles.index', $institucion_id))
            ->with('message', 'Rol eliminado');
    }
}
