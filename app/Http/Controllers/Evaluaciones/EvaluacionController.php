<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreEvaluacionRequest;
use App\Models\Cursos\Curso;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\Materia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($institucion_id, $curso_id, $materia_id)
    {
        return Inertia::render('Evaluaciones/Index', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'evaluaciones' => Evaluacion::where('materia_id', $materia_id)
                ->orderBy('fechaHoraComienzo', 'ASC')
                ->paginate(20)
                ->through(function ($evaluacion) {
                    return [
                        'id' => $evaluacion->id,
                        'nombre' => $evaluacion->nombre,
                        'fechaHoraComienzo' => Carbon::parse($evaluacion->fechaHoraComienzo)->format('d/m/y - H:i:s'),
                        'fechaHoraFinalizacion' => Carbon::parse($evaluacion->fechaHoraFinalizacion)->format('d/m/y - H:i:s'),
                    ];
                }),
        ]);
    }

    public function paginarEvaluaciones(Request $request, $institucion_id, $curso_id, $materia_id)
    {
        return Evaluacion::where('materia_id', $materia_id)
            ->orderBy('fechaHoraComienzo', 'ASC')
            ->paginate(20)
            ->through(function ($evaluacion) {
                return [
                    'id' => $evaluacion->id,
                    'nombre' => $evaluacion->nombre,
                    'fechaHoraComienzo' => Carbon::parse($evaluacion->fechaHoraComienzo)->format('d/m/y - H:i:s'),
                    'fechaHoraFinalizacion' => Carbon::parse($evaluacion->fechaHoraFinalizacion)->format('d/m/y - H:i:s'),
                ];
            });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institucion_id, $curso_id, $materia_id)
    {
        return Inertia::render('Evaluaciones/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvaluacionRequest $request, $institucion_id, $curso_id, $materia_id)
    {
        $evaluacion = new Evaluacion();
        $evaluacion->materia()->associate($materia_id);
        $evaluacion->nombre = $request->nombre;
        $evaluacion->descripcion = $request->descripcion;
        $evaluacion->fechaHoraComienzo = Carbon::parse($request->fechaHoraComienzo)->format('Y-m-d H:i:s');
        $evaluacion->fechaHoraFinalizacion = Carbon::parse($request->fechaHoraFinalizacion)->format('Y-m-d H:i:s');
        $evaluacion->save();

        echo 'Evaluaciones - Guardado';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($institucion_id, $curso_id, $materia_id, $id)
    {
        $evaluacion = Evaluacion::findOrFail($id);

        return Inertia::render('Evaluaciones/Show', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'evaluacion' => [
                'id' => $evaluacion->id,
                'nombre' => $evaluacion->nombre,
                'descripcion' => $evaluacion->descripcion,
                'fechaHoraComienzo' => Carbon::parse($evaluacion->fechaHoraComienzo)->format('d/m/y - H:i:s'),
                'fechaHoraFinalizacion' => Carbon::parse($evaluacion->fechaHoraFinalizacion)->format('d/m/y - H:i:s'),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($institucion_id, $curso_id, $materia_id, $id)
    {
        $evaluacion = Evaluacion::findOrFail($id);

        return Inertia::render('Evaluaciones/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'evaluacion' => [
                'id' => $evaluacion->id,
                'nombre' => $evaluacion->nombre,
                'descripcion' => $evaluacion->descripcion,
                'fechaHoraComienzo' => Carbon::parse($evaluacion->fechaHoraComienzo)->format('d-m-Y H:i:s'),
                'fechaHoraFinalizacion' => Carbon::parse($evaluacion->fechaHoraFinalizacion)->format('d-m-Y H:i:s'),
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEvaluacionRequest $request, $institucion_id, $curso_id, $materia_id, $id)
    {
        $evaluacion = Evaluacion::findOrFail($id);
        $evaluacion->nombre = $request->nombre;
        $evaluacion->descripcion = $request->descripcion;
        $evaluacion->fechaHoraComienzo = Carbon::parse($request->fechaHoraComienzo)->format('Y-m-d H:i:s');
        $evaluacion->fechaHoraFinalizacion = Carbon::parse($request->fechaHoraFinalizacion)->format('Y-m-d H:i:s');
        $evaluacion->save();

        echo 'Evaluaciones - Actualizada';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($institucion_id, $curso_id, $materia_id, $id)
    {
        Evaluacion::destroy($id);
        echo 'Evaluacion - Eliminada';
    }
}
