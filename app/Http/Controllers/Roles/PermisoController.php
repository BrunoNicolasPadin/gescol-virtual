<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StorePermisoRequest;
use App\Models\Instituciones\Institucion;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermisoController extends Controller
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
    public function create($institucion_id)
    {
        return Inertia::render('Roles/Permisos/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermisoRequest $request, $institucion_id)
    {
        for ($i = 0; $i < count($request->permisos); $i++) { 
            $permiso = new Permission();
            $permiso->name = $request->permisos[$i]['nombre'];
            $permiso->institucion()->associate($institucion_id);
            $permiso->save();
        }

        echo 'Guardado';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($institucion_id, $id)
    {
        return Inertia::render('Roles/Permisos/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'permiso' => Permission::findById($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePermisoRequest $request, $institucion_id, $id)
    {
        $permiso = Permission::findOrFail($id);
        $permiso->name = $request->nombre;
        $permiso->save();

        echo 'Actualizado';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($institucion_id, $id)
    {
        Permission::destroy($id);

        echo 'Eliminado';
    }
}
