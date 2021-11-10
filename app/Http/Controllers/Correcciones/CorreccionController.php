<?php

namespace App\Http\Controllers\Correcciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Archivos\StoreArchivoRequest;
use App\Models\Correcciones\Correccion;
use App\Models\Cursos\Curso;
use App\Models\Entregas\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\Materia;
use App\Services\Archivos\ArchivoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CorreccionController extends Controller
{
    protected $archivoService;

    public function __construct(ArchivoService $archivoService)

    {
        $this->archivoService = $archivoService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institucion_id, $curso_id, $materia_id, $evaluacion_id, $entrega_id)
    {
        return Inertia::render('Correcciones/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'evaluacion' => Evaluacion::findOrFail($evaluacion_id),
            'entrega' => Entrega::with('alumnoMateria.rolUser.user')
                ->findOrFail($entrega_id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArchivoRequest $request, $institucion_id, $curso_id, $materia_id, $evaluacion_id, $entrega_id)
    {
        $correccion = new Correccion();
        $correccion->entrega()->associate($entrega_id);
        
        $nombreArchivo = null;
        if ($request->hasFile('archivo')) {
            $carpeta = 'Correcciones/';
            $nombreArchivo = $this->archivoService->subirArchivo($request, $carpeta);
        }

        $correccion->archivo = $nombreArchivo;
        $correccion->save();

        echo 'Correccion - Guardada';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($institucion_id, $curso_id, $materia_id, $evaluacion_id, $entrega_id, $id)
    {
        $correccion = Correccion::findOrFail($id);
        /* Storage::disk('s3')->delete('Competencias/Escudos/' . $competencia->escudo); */
        Storage::delete($correccion->archivo);
        Correccion::destroy($id);
        echo 'Correccion - Eliminado';
    }
}
