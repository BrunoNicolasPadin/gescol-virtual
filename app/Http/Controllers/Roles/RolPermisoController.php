<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRolPermisoRequest;
use App\Models\Instituciones\Institucion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolPermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institucion_id, $rol_id)
    {
        $rol = Role::findById($rol_id);
        $permisos = Permission::where('institucion_id', $institucion_id)->get();
        $permisosDelRol = Role::findById($rol_id)->permissions;

        foreach ($permisosDelRol as $permisoRol) {
            $permisos = $permisos->filter(function ($item) use($permisoRol) {
                return $item->id != $permisoRol->id;
            });
        }

        return Inertia::render('Roles/RolPermisos/Create', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
            'rol' => $rol,
            'permisos' => $permisos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolPermisoRequest $request, $institucion_id, $rol_id)
    {
        $rol = Role::findOrFail($rol_id);
        $rol->givePermissionTo($request->permiso_id);

        return redirect(route('rolPermisos.create', [$institucion_id, $rol_id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($institucion_id, $rol_id, $id)
    {
        $rol = Role::findOrFail($rol_id);
        $rol->revokePermissionTo($id);
    }
}
