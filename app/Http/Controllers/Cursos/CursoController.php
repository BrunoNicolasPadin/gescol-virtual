<?php

namespace App\Http\Controllers\Cursos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cursos\StoreCursoRequest;
use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($institucion_id)
    {
        return Inertia::render('Cursos/Index', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
            'cursos' => Curso::where('institucion_id', $institucion_id)->orderBy('nombre')->paginate(10),
        ]);
    }

    public function paginarCursos(Request $request, $institucion_id)
    {
        return Curso::where('institucion_id', $institucion_id)->orderBy('nombre')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institucion_id)
    {
        return Inertia::render('Cursos/Create', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCursoRequest $request, $institucion_id)
    {
        for ($i = 0; $i < count($request->cursos); $i++) { 
            $curso = new Curso();
            $curso->institucion()->associate($institucion_id);
            $curso->nombre = $request->cursos[$i]['nombre'];
            $curso->save();
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
        return Inertia::render('Cursos/Edit', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
            'curso' => Curso::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCursoRequest $request, $institucion_id, $id)
    {
        $curso = Curso::findOrFail($id);
        $curso->nombre = $request->nombre;
        $curso->save();

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
        Curso::destroy($id);
        echo 'Eliminado';
    }
}
