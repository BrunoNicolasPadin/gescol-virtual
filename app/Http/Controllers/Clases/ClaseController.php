<?php

namespace App\Http\Controllers\Clases;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clases\StoreClaseRequest;
use App\Models\Clases\Clase;
use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\Materia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($institucion_id, $curso_id, $materia_id)
    {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institucion_id, $curso_id, $materia_id)
    {
        return Inertia::render('Clases/Create', [
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
    public function store(StoreClaseRequest $request, $institucion_id, $curso_id, $materia_id)
    {
        $clase = new Clase();
        $clase->materia()->associate($materia_id);
        $clase->nombre = $request->nombre;
        $clase->descripcion = $request->descripcion;
        $clase->save();

        echo 'Clase guardada';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($institucion_id, $curso_id, $materia_id, $id)
    {
        $clase = Clase::with('comentarios.user')->findOrFail($id);

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
                'comentarios' => $clase->comentarios()->paginate(1),
            ],
        ]);
    }

    public function paginarComentarios(Request $request, $institucion_id, $curso_id, $materia_id, $id)
    {
        $clase = Clase::with('comentarios.user')->findOrFail($id);
        return $clase->comentarios()->paginate(1);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($institucion_id, $curso_id, $materia_id, $id)
    {
        return Inertia::render('Clases/Edit', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'clase' => Clase::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClaseRequest $request, $institucion_id, $curso_id, $materia_id, $id)
    {
        $clase = Clase::findOrFail($id);
        $clase->nombre = $request->nombre;
        $clase->descripcion = $request->descripcion;
        $clase->save();

        echo 'Clases - Actualizada';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($institucion_id, $curso_id, $materia_id, $id)
    {
        Clase::destroy($id);
        echo 'Clase - Eliminada';
    }
}
