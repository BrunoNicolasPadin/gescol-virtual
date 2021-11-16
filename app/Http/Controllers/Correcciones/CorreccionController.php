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

    public function store(StoreArchivoRequest $request, $institucion_id, $curso_id, $materia_id, $evaluacion_id, $entrega_id)
    {
        $this->authorize('create', Correccion::class);

        $correccion = new Correccion();
        $correccion->entrega()->associate($entrega_id);
        
        $nombreArchivo = null;
        if ($request->hasFile('archivo')) {
            $carpeta = 'Correcciones/';
            $nombreArchivo = $this->archivoService->subirArchivo($request, $carpeta);
        }

        $correccion->archivo = $nombreArchivo;
        $correccion->save();

        return redirect()->route('entregas.show', [$institucion_id, $curso_id, $materia_id, $evaluacion_id, $entrega_id])
            ->with('message', 'Correccion agregada');
    }

    public function destroy($institucion_id, $curso_id, $materia_id, $evaluacion_id, $entrega_id, Correccion $correccione)
    {
        $this->authorize('delete', $correccione);

        /* Storage::disk('s3')->delete('Correcciones/' . $correccione->archivo); */
        Storage::delete($correccione->archivo);
        $correccione->delete();
        
        return redirect()->route('entregas.show', [$institucion_id, $curso_id, $materia_id, $evaluacion_id, $entrega_id])
            ->with('message', 'Correccion eliminada');
    }
}
