<?php

namespace App\Http\Controllers\Entregas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Entregas\StoreEntregaRequest;
use App\Models\Correcciones\Correccion;
use App\Models\Cursos\Curso;
use App\Models\Entregas\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\Materia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EntregaController extends Controller
{
    public function index($institucion_id, $curso_id, $materia_id, $evaluacion_id)
    {
        $this->authorize('viewAny', Entrega::class);

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

    public function show($institucion_id, $curso_id, $materia_id, $evaluacion_id, $id)
    {
        $entrega = Entrega::with(['alumnoMateria.rolUser.user', 'comentarios.user'])->findOrFail($id);

        return Inertia::render('Entregas/Show', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'evaluacion' => Evaluacion::findOrFail($evaluacion_id),
            'correcciones' => Correccion::where('entrega_id', $id)->get(),
            'entrega' => [
                'id' => $entrega->id,
                'calificacion' => $entrega->calificacion,
                'comentario' => $entrega->comentario,
                'alumno' => $entrega->alumnoMateria->rolUser->user->name,
                'archivos' => $entrega->archivos,
                'comentarios' => $entrega->comentarios()->paginate(10),
            ],
        ]);
    }

    public function paginarComentarios(Request $request, $institucion_id, $curso_id, $materia_id, $evaluacion_id, $id)
    {
        $entrega = Entrega::with('comentarios.user')->findOrFail($id);
        return $entrega->comentarios()->paginate(10);

    }

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

    public function update(StoreEntregaRequest $request, $institucion_id, $curso_id, $materia_id, $evaluacion_id, $id)
    {
        $entrega = Entrega::findOrFail($id);
        $entrega->calificacion = $request->calificacion;
        $entrega->comentario = $request->comentario;
        $entrega->save();

        return redirect()->route('entregas.show', [$institucion_id, $curso_id, $materia_id, $evaluacion_id, $id])
            ->with('message', 'Entrega calificada');
    }

    public function destroy($institucion_id, $curso_id, $materia_id, $evaluacion_id, $id)
    {
        Entrega::destroy($id);
        return redirect()->route('entregas.index', [$institucion_id, $curso_id, $materia_id, $evaluacion_id])
            ->with('message', 'Entrega eliminada');
    }
}
