<?php

namespace App\Http\Controllers\Cursos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cursos\StoreCursoRequest;
use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use Inertia\Inertia;

class CursoController extends Controller
{
    public function index($institucion_id)
    {
        $this->authorize('viewAny', Curso::class);

        return Inertia::render('Cursos/Index', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'cursos' => Curso::where('institucion_id', $institucion_id)
                ->orderBy('nombre')
                ->paginate(10),
        ]);
    }

    public function paginarCursos($institucion_id)
    {
        return Curso::where('institucion_id', $institucion_id)
            ->orderBy('nombre')
            ->paginate(10);
    }

    public function create($institucion_id)
    {
        $this->authorize('create', Curso::class);

        return Inertia::render('Cursos/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
        ]);
    }

    public function store(StoreCursoRequest $request, $institucion_id)
    {
        $this->authorize('create', Curso::class);

        for ($i = 0; $i < count($request->cursos); $i++) {
            $curso = new Curso();
            $curso->institucion()->associate($institucion_id);
            $curso->nombre = $request->cursos[$i]['nombre'];
            $curso->save();
        }
        return redirect()->route('cursos.index', $institucion_id)
            ->with('message', 'Curso registrado');
    }

    public function edit($institucion_id, Curso $curso)
    {
        $this->authorize('update', $curso);

        return Inertia::render('Cursos/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => $curso,
        ]);
    }

    public function update(
        StoreCursoRequest $request,
        $institucion_id,
        Curso $curso
    ) {
        $this->authorize('update', $curso);

        $curso->nombre = $request->nombre;
        $curso->save();

        return redirect()->route('cursos.index', $institucion_id)
            ->with('message', 'Curso actualizado');
    }

    public function destroy($institucion_id, Curso $curso)
    {
        $this->authorize('delete', $curso);

        $curso->delete();

        return redirect()->route('cursos.index', $institucion_id)
            ->with('message', 'Curso eliminado');
    }
}
