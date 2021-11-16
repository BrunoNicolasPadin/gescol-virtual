<?php

namespace App\Http\Controllers\Clases;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clases\StoreClaseRequest;
use App\Models\Archivos\Archivo;
use App\Models\Clases\Clase;
use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ClaseController extends Controller
{
    public function index($institucion_id, $curso_id, $materia_id)
    {
        $this->authorize('viewAny', [Clase::class, $materia_id]);

        return Inertia::render('Clases/Index', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'clases' => Clase::where('materia_id', $materia_id)
                ->orderBy('created_at', 'ASC')
                ->paginate(20),
        ]);
    }

    public function paginarClases(Request $request, $institucion_id, $curso_id, $materia_id)
    {
        return Clase::where('materia_id', $materia_id)
            ->orderBy('created_at', 'ASC')
            ->paginate(20);
    }

    public function create($institucion_id, $curso_id, $materia_id)
    {
        $this->authorize('create', Clase::class);

        return Inertia::render('Clases/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
        ]);
    }

    public function store(StoreClaseRequest $request, $institucion_id, $curso_id, $materia_id)
    {
        $this->authorize('create', Clase::class);

        $clase = new Clase();
        $clase->materia()->associate($materia_id);
        $clase->nombre = $request->nombre;
        $clase->descripcion = $request->descripcion;
        $clase->save();

        return redirect()->route('clases.index', [$institucion_id, $curso_id, $materia_id])
            ->with('message', 'Clase registrada');
    }

    public function show($institucion_id, $curso_id, $materia_id, $id)
    {
        $clase = Clase::with('comentarios.user')->findOrFail($id);
        $this->authorize('view', $clase);

        return Inertia::render('Clases/Show', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'clase' => [
                'id' => $clase->id,
                'nombre' => $clase->nombre,
                'descripcion' => $clase->descripcion,
                'archivos' => $clase->archivos,
                'comentarios' => $clase->comentarios()->paginate(10),
            ],
        ]);
    }

    public function paginarComentarios(Request $request, $institucion_id, $curso_id, $materia_id, $id)
    {
        $clase = Clase::with('comentarios.user')->findOrFail($id);
        return $clase->comentarios()->paginate(10);

    }

    public function edit($institucion_id, $curso_id, $materia_id, Clase $clase)
    {
        $this->authorize('update', $clase);

        return Inertia::render('Clases/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'clase' => $clase,
        ]);
    }

    public function update(StoreClaseRequest $request, $institucion_id, $curso_id, $materia_id, Clase $clase)
    {
        $this->authorize('update', $clase);

        $clase->nombre = $request->nombre;
        $clase->descripcion = $request->descripcion;
        $clase->save();

        return redirect()->route('clases.index', [$institucion_id, $curso_id, $materia_id])
            ->with('message', 'Clase actualizada');
    }

    public function destroy($institucion_id, $curso_id, $materia_id, Clase $clase)
    {
        $this->authorize('delete', $clase);

        $archivosClase = Archivo::where('fileable_id', $clase->id)->get();
        foreach ($archivosClase as $archivoClase) {
            Storage::delete($archivoClase->archivo);
            $archivoClase->delete();
        }
        $clase->delete();

        return redirect()->route('clases.index', [$institucion_id, $curso_id, $materia_id])
            ->with('message', 'Clase eliminada');
    }
}
