<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRolRequest;
use App\Models\Instituciones\Institucion;
use App\Models\Roles\Rol;
use Inertia\Inertia;

class RolController extends Controller
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
        return Inertia::render('Roles/Create', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolRequest $request, $institucion_id)
    {
        for ($i = 0; $i < count($request->roles); $i++) { 
            $rol = new Rol();
            $rol->nombre = $request->roles[$i]['nombre'];
            $rol->institucion()->associate($institucion_id);
            $rol->save();
        }

        echo 'Roles - Guardado';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($institucion_id, $id)
    {
        return Inertia::render('Roles/Edit', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
            'rol' => Rol::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRolRequest $request, $institucion_id, $id)
    {
        $rol = Rol::findOrFail($id);
        $rol->nombre = $request->nombre;
        $rol->save();

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
        Rol::destroy($id);
        echo 'Eliminado';
    }
}
