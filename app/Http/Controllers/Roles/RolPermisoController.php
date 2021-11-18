<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRolPermisoRequest;
use App\Models\Instituciones\Institucion;
use App\Models\Permisos\Permiso;
use App\Models\Roles\PermisoRol;
use App\Models\Roles\Rol;
use Inertia\Inertia;

class RolPermisoController extends Controller
{
    public function index($institucion_id, $rol_id)
    {
        return Inertia::render('Roles/RolPermisos/Index', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'rol' => Rol::findOrFail($rol_id),
            'permisos' => PermisoRol::where('permisos_roles.rol_id', $rol_id)
                ->join('permisos', 'permisos_roles.permiso_id', 'permisos.id')
                ->orderBy('permisos.nombre')
                ->select('permisos.nombre', 'permisos_roles.id')
                ->get(),
        ]);
    }

    public function create($institucion_id, $rol_id)
    {
        $this->authorize('create', PermisoRol::class);

        $rol = Rol::findOrFail($rol_id);
        $permisos = Permiso::orderBy('nombre')->get();
        $permisosDelRolActualmente = PermisoRol::where('rol_id', $rol_id)
            ->get();

        foreach ($permisosDelRolActualmente as $permisoRol) {
            $permisos = $permisos->filter(function ($item) use ($permisoRol) {
                return $item->id !== $permisoRol->permiso_id;
            });
        }

        return Inertia::render('Roles/RolPermisos/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'rol' => $rol,
            'permisos' => $permisos,
        ]);
    }

    public function store(
        StoreRolPermisoRequest $request,
        $institucion_id,
        $rol_id
    ) {
        $this->authorize('create', PermisoRol::class);

        $permisoRol = new PermisoRol();
        $permisoRol->permiso()->associate($request->permiso_id);
        $permisoRol->rol()->associate($rol_id);
        $permisoRol->save();

        return redirect(route('rolPermisos.index', [$institucion_id, $rol_id]))
            ->with('message', 'Permiso agregado');
    }

    public function destroy($institucion_id, $rol_id, PermisoRol $permiso)
    {
        $this->authorize('delete', $permiso);

        $permiso->delete();

        return redirect(route('rolPermisos.index', [$institucion_id, $rol_id]))
            ->with('message', 'Permiso eliminado');
    }
}
