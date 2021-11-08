<?php

namespace App\Http\Controllers\Materias;

use App\Http\Controllers\Controller;
use App\Http\Requests\Materias\StoreMateriaRequest;
use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\Materia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($institucion_id, $curso_id)
    {
        return Inertia::render('Materias/Index', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materias' => Materia::where('curso_id', $curso_id)
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institucion_id, $curso_id)
    {
        return Inertia::render('Materias/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMateriaRequest $request, $institucion_id, $curso_id)
    {
        for ($i = 0; $i < count($request->materias); $i++) { 
            $materia = new Materia();
            $materia->curso()->associate($curso_id);
            $materia->nombre = $request->materias[$i]['nombre'];
            $materia->save();
        }

        echo 'Materias - Guardadas';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($institucion_id, $curso_id, $id)
    {
        return Inertia::render('Materias/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMateriaRequest $request, $institucion_id, $curso_id, $id)
    {
        $materia = Materia::where('curso_id', $curso_id)->findOrFail($id);
        $materia->nombre = $request->nombre;
        $materia->save();

        echo 'Materias - Actualizado';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($institucion_id, $curso_id, $id)
    {
        Materia::destroy($id);
        echo 'Materia - Eliminada';
    }
}
