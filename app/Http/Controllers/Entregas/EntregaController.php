<?php

namespace App\Http\Controllers\Entregas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Entregas\StoreEntregaRequest;
use App\Models\Cursos\Curso;
use App\Models\Entregas\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\Materia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EntregaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($institucion_id, $curso_id, $materia_id, $evaluacion_id)
    {
        return Inertia::render('Entregas/Index', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'evaluacion' => Evaluacion::findOrFail($evaluacion_id),
            'entregas' => Entrega::where('evaluacion_id', $evaluacion_id)
                ->with('alumnoMateria.rolUser.user')
                ->get(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($institucion_id, $curso_id, $materia_id, $evaluacion_id, $id)
    {
        $entrega = Entrega::with('alumnoMateria.rolUser.user')->findOrFail($id);

        return Inertia::render('Entregas/Show', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'evaluacion' => Evaluacion::findOrFail($evaluacion_id),
            'entrega' => [
                'id' => $entrega->id,
                'calificacion' => $entrega->calificacion,
                'comentario' => $entrega->comentario,
                'alumno' => $entrega->alumnoMateria->rolUser->user->name,
                'archivos' => $entrega->archivos,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($institucion_id, $curso_id, $materia_id, $evaluacion_id, $id)
    {
        return Inertia::render('Entregas/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'evaluacion' => Evaluacion::findOrFail($evaluacion_id),
            'entrega' => Entrega::with('alumnoMateria.rolUser.user')
                ->findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEntregaRequest $request, $institucion_id, $curso_id, $materia_id, $evaluacion_id, $id)
    {
        $entrega = Entrega::findOrFail($id);
        $entrega->calificacion = $request->calificacion;
        $entrega->comentario = $request->comentario;
        $entrega->save();

        echo 'Entrega - Actualizada';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($institucion_id, $curso_id, $materia_id, $evaluacion_id, $id)
    {
        Entrega::destroy($id);
        echo 'Entrega - Eliminada';
    }
}
