<?php

namespace App\Http\Controllers\Materias;

use App\Http\Controllers\Controller;
use App\Http\Requests\Materias\StoreMateriaRequest;
use App\Jobs\Materias\EliminarMateriaJob;
use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\Materia;
use Inertia\Inertia;

class MateriaController extends Controller
{
    public function index($institucion_id, $curso_id)
    {
        $this->authorize('viewAny', Materia::class);

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

    public function create($institucion_id, $curso_id)
    {
        $this->authorize('create', Materia::class);

        return Inertia::render('Materias/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
        ]);
    }

    public function store(
        StoreMateriaRequest $request,
        $institucion_id,
        $curso_id
    ) {
        $this->authorize('create', Materia::class);

        for ($i = 0; $i < count($request->materias); $i++) {
            $materia = new Materia();
            $materia->curso()->associate($curso_id);
            $materia->nombre = $request->materias[$i]['nombre'];
            $materia->save();
        }

        return redirect(route('materias.index', [$institucion_id, $curso_id]))
            ->with('message', 'Materias agregadas');
    }

    public function edit($institucion_id, $curso_id, Materia $materia)
    {
        $this->authorize('update', $materia);

        return Inertia::render('Materias/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => $materia,
        ]);
    }

    public function update(
        StoreMateriaRequest $request,
        $institucion_id,
        $curso_id,
        Materia $materia
    ) {
        $this->authorize('update', $materia);

        $materia->nombre = $request->nombre;
        $materia->save();

        return redirect(route('materias.index', [$institucion_id, $curso_id]))
            ->with('message', 'Materia actualizada');
    }

    public function destroy($institucion_id, $curso_id, Materia $materia)
    {
        $this->authorize('delete', $materia);

        EliminarMateriaJob::dispatch($materia);

        return redirect(route('materias.index', [$institucion_id, $curso_id]))
            ->with('message', 'Materia eliminada');
    }
}
