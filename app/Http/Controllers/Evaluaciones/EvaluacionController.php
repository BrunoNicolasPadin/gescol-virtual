<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreEvaluacionRequest;
use App\Jobs\Evaluaciones\EliminarEvaluacionJob;
use App\Models\Cursos\Curso;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\Materia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EvaluacionController extends Controller
{
    public function index($institucion_id, $curso_id, $materia_id)
    {
        $this->authorize('viewAny', [Evaluacion::class, $materia_id]);

        return Inertia::render('Evaluaciones/Index', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'evaluaciones' => Evaluacion::where('materia_id', $materia_id)
                ->orderBy('fechaHoraComienzo', 'ASC')
                ->paginate(20)
                ->through(function ($evaluacion) {
                    return [
                        'id' => $evaluacion->id,
                        'nombre' => $evaluacion->nombre,
                        'fechaHoraComienzo' => Carbon::parse(
                            $evaluacion->fechaHoraComienzo
                        )->format('d/m/y - H:i:s'),
                        'fechaHoraFinalizacion' => Carbon::parse(
                            $evaluacion->fechaHoraFinalizacion
                        )->format('d/m/y - H:i:s'),
                    ];
                }),
        ]);
    }

    public function paginarEvaluaciones(
        Request $request,
        $institucion_id,
        $curso_id,
        $materia_id
    ) {
        return Evaluacion::where('materia_id', $materia_id)
            ->orderBy('fechaHoraComienzo', 'ASC')
            ->paginate(20)
            ->through(function ($evaluacion) {
                return [
                    'id' => $evaluacion->id,
                    'nombre' => $evaluacion->nombre,
                    'fechaHoraComienzo' => Carbon::parse(
                        $evaluacion->fechaHoraComienzo
                    )->format('d/m/y - H:i:s'),
                    'fechaHoraFinalizacion' => Carbon::parse(
                        $evaluacion->fechaHoraFinalizacion
                    )->format('d/m/y - H:i:s'),
                ];
            });
    }

    public function create($institucion_id, $curso_id, $materia_id)
    {
        $this->authorize('create', Evaluacion::class);

        return Inertia::render('Evaluaciones/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
        ]);
    }

    public function store(
        StoreEvaluacionRequest $request,
        $institucion_id,
        $curso_id,
        $materia_id
    ) {
        $this->authorize('create', Evaluacion::class);

        $evaluacion = new Evaluacion();
        $evaluacion->materia()->associate($materia_id);
        $evaluacion->nombre = $request->nombre;
        $evaluacion->descripcion = $request->descripcion;
        $evaluacion->fechaHoraComienzo = Carbon::parse(
            $request->fechaHoraComienzo
        )->format('Y-m-d H:i:s');
        $evaluacion->fechaHoraFinalizacion = Carbon::parse(
            $request->fechaHoraFinalizacion
        )->format('Y-m-d H:i:s');

        $evaluacion->save();

        return redirect()->route('evaluaciones.index', [
            $institucion_id, $curso_id, $materia_id,
        ])
            ->with('message', 'Evaluación agregada');
    }

    public function show($institucion_id, $curso_id, $materia_id, $id)
    {
        $evaluacion = Evaluacion::with('comentarios.user')->findOrFail($id);
        $this->authorize('view', $evaluacion);
        return Inertia::render('Evaluaciones/Show', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'evaluacion' => [
                'id' => $evaluacion->id,
                'nombre' => $evaluacion->nombre,
                'descripcion' => $evaluacion->descripcion,
                'fechaHoraComienzo' => Carbon::parse(
                    $evaluacion->fechaHoraComienzo
                )->format('d/m/y - H:i:s'),
                'fechaHoraFinalizacion' => Carbon::parse(
                    $evaluacion->fechaHoraFinalizacion
                )->format('d/m/y - H:i:s'),
                'archivos' => $evaluacion->archivos,
                'comentarios' => $evaluacion->comentarios()->paginate(10),
            ],
        ]);
    }

    public function paginarComentarios(
        Request $request,
        $institucion_id,
        $curso_id,
        $materia_id,
        $id
    ) {
        $evaluacion = Evaluacion::with('comentarios.user')
            ->findOrFail($id);
        return $evaluacion->comentarios()->paginate(10);
    }

    public function edit(
        $institucion_id,
        $curso_id,
        $materia_id,
        Evaluacion $evaluacione
    ) {
        $this->authorize('update', $evaluacione);

        return Inertia::render('Evaluaciones/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'evaluacion' => [
                'id' => $evaluacione->id,
                'nombre' => $evaluacione->nombre,
                'descripcion' => $evaluacione->descripcion,
                'fechaHoraComienzo' => Carbon::parse(
                    $evaluacione->fechaHoraComienzo
                )->format('d-m-Y H:i:s'),
                'fechaHoraFinalizacion' => Carbon::parse(
                    $evaluacione->fechaHoraFinalizacion
                )->format('d-m-Y H:i:s'),
            ],
        ]);
    }

    public function update(
        StoreEvaluacionRequest $request,
        $institucion_id,
        $curso_id,
        $materia_id,
        Evaluacion $evaluacione
    ) {
        $this->authorize('update', $evaluacione);

        $evaluacione->nombre = $request->nombre;
        $evaluacione->descripcion = $request->descripcion;
        $evaluacione->fechaHoraComienzo = Carbon::parse(
            $request->fechaHoraComienzo
        )->format('Y-m-d H:i:s');
        $evaluacione->fechaHoraFinalizacion = Carbon::parse(
            $request->fechaHoraFinalizacion
        )->format('Y-m-d H:i:s');
        $evaluacione->save();

        return redirect()->route('evaluaciones.show', [
            $institucion_id,
            $curso_id,
            $materia_id,
            $evaluacione->id,
        ])
            ->with('message', 'Evaluación actualizada');
    }

    public function destroy(
        $institucion_id,
        $curso_id,
        $materia_id,
        Evaluacion $evaluacione
    ) {
        $this->authorize('delete', $evaluacione);

        EliminarEvaluacionJob::dispatch($evaluacione);

        return redirect()->route('evaluaciones.index', [
            $institucion_id,
            $curso_id,
            $materia_id,
        ])
            ->with('message', 'Evaluación eliminada');
    }
}
