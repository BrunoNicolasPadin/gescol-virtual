<?php

namespace App\Http\Controllers\Materias;

use App\Http\Controllers\Controller;
use App\Models\Materias\AlumnoMateria;
use App\Models\Roles\RolUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoMateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($institucion_id, $curso_id, $materia_id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institucion_id, $curso_id, $materia_id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $institucion_id, $curso_id, $materia_id)
    {
        $rolUser = RolUser::where('user_id', Auth::id())->first();
        $alumnoMateria = new AlumnoMateria();
        $alumnoMateria->rolUser()->associate($rolUser->id);
        $alumnoMateria->materia()->associate($materia_id);
        $alumnoMateria->save();

        echo 'Alumno materia - Guardado';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($institucion_id, $curso_id, $materia_id, $id)
    {
        AlumnoMateria::destroy($id);
        echo 'Alumno materia - Eliminado';
    }
}
