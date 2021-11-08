<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instituciones\StoreInscripcionInstitucionRequest;
use App\Models\Instituciones\Institucion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

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
            'roles' => Role::where('institucion_id', $institucion_id)->orderBy('name')->get(),
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
        $user = User::findOrFail(Auth::id());
        $role = Role::findOrFail($request->rol_id);
        $user->assignRole($role);

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
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
            'roles' => Role::where('institucion_id', $institucion_id)->orderBy('name')->get(),
            'inscripcion' => $user->roles->where('institucion_id', $institucion_id),
            'user_id' => $id,
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
        DB::table('model_has_roles')->where('model_id', $id)->where('role_id', $request->rol_viejo_id)->delete();

        $user = User::findOrFail($id);
        $role = Role::findOrFail($request->rol_id);
        $user->assignRole($role);

        echo 'Rol actualizado';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($institucion_id, $id)
    {
        //
    }
}
