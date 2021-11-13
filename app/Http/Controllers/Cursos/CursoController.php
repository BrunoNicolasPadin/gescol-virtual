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
    public function __construct()
    {
        $this->authorizeResource(Curso::class, 'curso');
    }

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

    public function create($institucion_id)
    {
        return Inertia::render('Cursos/Create', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
        ]);
    }

    public function store(StoreCursoRequest $request, $institucion_id)
    {
        for ($i = 0; $i < count($request->cursos); $i++) { 
            $curso = new Curso();
            $curso->institucion()->associate($institucion_id);
            $curso->nombre = $request->cursos[$i]['nombre'];
            $curso->save();
        }
        return redirect()->route('cursos.index', $institucion_id)
            ->with('message', 'Curso registrado');
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('Cursos/Edit', [
            'institucion' => Institucion::select('id', 'nombre')->findOrFail($institucion_id),
            'curso' => Curso::findOrFail($id),
        ]);
    }

    public function update(StoreCursoRequest $request, $institucion_id, $id)
    {
        $curso = Curso::findOrFail($id);
        $curso->nombre = $request->nombre;
        $curso->save();

        return redirect()->route('cursos.index', $institucion_id)
            ->with('message', 'Curso actualizado');
    }

    public function destroy($institucion_id, $id)
    {
        Curso::destroy($id);
        return redirect()->route('cursos.index', $institucion_id)
            ->with('message', 'Curso eliminado');
    }
}
