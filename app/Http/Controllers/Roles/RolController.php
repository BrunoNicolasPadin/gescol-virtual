<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRolRequest;
use App\Http\Requests\Roles\UpdateRolRequest;
use App\Models\Instituciones\Institucion;
use App\Models\Roles\Rol;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class RolController extends Controller
{
    public function create($institucion_id)
    {
        $this->authorize('create', Rol::class);

        return Inertia::render('Roles/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
        ]);
    }

    public function store(StoreRolRequest $request, $institucion_id)
    {
        $this->authorize('create', Rol::class);

        for ($i = 0; $i < count($request->roles); $i++) {
            $rol = new Rol();
            $rol->nombre = $request->roles[$i]['nombre'];
            $rol->claveDeAcceso = Hash::make($request->claveDeAcceso);
            $rol->institucion()->associate($institucion_id);
            $rol->save();
        }

        return redirect(route('panel.mostrarRoles', $institucion_id))
            ->with('message', 'Roles agregados');
    }

    public function edit($institucion_id, Rol $role)
    {
        $this->authorize('update', $role);

        return Inertia::render('Roles/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'rol' => $role,
        ]);
    }

    public function update(
        UpdateRolRequest $request,
        $institucion_id,
        Rol $role
    ) {
        $this->authorize('update', $role);
        /* Verificar si coincide la clave de acceso actual con la ingresada */
        if (! $request->claveDeAccesoVieja === null) {
            if (Hash::check(
                $request->claveDeAccesoVieja,
                $role->claveDeAcceso
            )) {
                $role->claveDeAcceso = Hash::make($request->claveDeAccesoNueva);
            } else {
                return redirect()->back()
                    ->with(
                        'message',
                        'La clave de acceso actual ingresada no es la correcta'
                    );
            }
        }
        $role->nombre = $request->nombre;
        $role->save();
        return redirect(route('panel.mostrarRoles', $institucion_id))
            ->with('message', 'Rol actualizado');
    }

    public function destroy($institucion_id, Rol $role)
    {
        $this->authorize('delete', $role);

        $role->delete();

        return redirect(route('panel.mostrarRoles', $institucion_id))
            ->with('message', 'Rol eliminado');
    }
}
