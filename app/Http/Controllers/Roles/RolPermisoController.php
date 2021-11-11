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
    public function index()
    {
        //
    }

    public function create($institucion_id, $rol_id)
    {
       $rol = Rol::findOrFail($rol_id);
        $permisos = Permiso::orderBy('nombre')->get();
        $permisosDelRolActualmente = PermisoRol::where('rol_id', $rol_id)->get();

        foreach ($permisosDelRolActualmente as $permisoRol) {
            $permisos = $permisos->filter(function ($item) use($permisoRol) {
                return $item->id != $permisoRol->permiso_id;
            });
        }

        return Inertia::render('Roles/RolPermisos/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'rol' => $rol,
            'permisos' => $permisos,
        ]);
    }

    public function store(StoreRolPermisoRequest $request, $institucion_id, $rol_id)
    {
        $permisoRol = new PermisoRol();
        $permisoRol->permiso()->associate($request->permiso_id);
        $permisoRol->rol()->associate($rol_id);
        $permisoRol->save();

        echo 'Permiso del rol - Guardado';
    }

    public function destroy($institucion_id, $rol_id, $id)
    {
        PermisoRol::destroy($id);
        echo 'Permiso del rol - Eliminado';
    }
}
