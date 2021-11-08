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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institucion_id)
    {
        return Inertia::render('Instituciones/Inscripciones/Create', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
            'roles' => Rol::where('institucion_id', $institucion_id)->orderBy('nombre')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInscripcionInstitucionRequest $request, $institucion_id)
    {
        $rolUser = new RolUser();
        $rolUser->rol()->associate($request->rol_id);
        $rolUser->user()->associate(Auth::id());
        $rolUser->save();

        echo 'Rol asignado al usuario';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($institucion_id, $id)
    {
        $user = User::where('id', $id)->first();
        return Inertia::render('Instituciones/Inscripciones/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'roles' => Rol::where('institucion_id', $institucion_id)
                ->orderBy('nombre')->get(),
            'inscripcion' => RolUser::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreInscripcionInstitucionRequest $request, $institucion_id, $id)
    {
        $rolUser = RolUser::findOrFail($id);
        $rolUser->rol()->associate($request->rol_id);
        $rolUser->save();

        echo 'Inscripcion actualizada';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($institucion_id, $id)
    {
        RolUser::destroy($id);
        echo 'Inscripcion eliminada';
    }
}
