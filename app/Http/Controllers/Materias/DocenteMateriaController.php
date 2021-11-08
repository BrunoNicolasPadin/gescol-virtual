<?php

namespace App\Http\Controllers\Materias;

use App\Http\Controllers\Controller;
use App\Http\Requests\Materias\StoreDocenteMateriaRequest;
use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\DocenteMateria;
use App\Models\Materias\Materia;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class DocenteMateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($institucion_id, $curso_id, $materia_id)
    {
        return Inertia::render('Materias/Docentes/Index', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'docentes' => DocenteMateria::where('materia_id', $materia_id)
                ->with('user')
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institucion_id, $curso_id, $materia_id)
    {
        return Inertia::render('Materias/Docentes/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'docentes' => User::select('id', 'name')->role('Docente')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocenteMateriaRequest $request, $institucion_id, $curso_id, $materia_id)
    {
        for ($i = 0; $i < count($request->docentesMateria); $i++) { 
            $docenteMateria = new DocenteMateria();
            $docenteMateria->user()->associate($request->docentesMateria[$i]['docente_id']);
            $docenteMateria->materia()->associate($materia_id);
            $docenteMateria->save();
        }

        echo 'Docente de la materia - Guardado';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($institucion_id, $curso_id, $materia_id, $id)
    {
        DocenteMateria::destroy($id);
        echo 'Docente materia - eliminado';
    }
}
