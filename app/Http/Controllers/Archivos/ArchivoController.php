<?php

namespace App\Http\Controllers\Archivos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Archivos\StoreArchivoRequest;
use App\Models\Archivos\Archivo;
use App\Services\Archivos\ArchivoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ArchivoController extends Controller
{
    protected $archivoService;

    public function __construct(ArchivoService $archivoService)

    {
        $this->archivoService = $archivoService;
    }

    public function create(Request $request)
    {
        return Inertia::render('Archivos/Create', [
            'id' => $request->id,
            'type' => $request->type,
            'carpeta' => $request->carpeta,
        ]);
    }

    public function store(StoreArchivoRequest $request)
    {
        $archivo = new Archivo();
        $archivo->fileable_type = $request->type;
        $archivo->fileable_id = $request->id;
        
        $nombreArchivo = null;
        if ($request->hasFile('archivo')) {
            $carpeta = $request->carpeta;
            $nombreArchivo = $this->archivoService->subirArchivo($request, $carpeta);
        }

        $archivo->archivo = $nombreArchivo;
        $archivo->save();

        return back()->with('message', 'Archivo guardado');
    }

    public function destroy($id)
    {
        $archivo = Archivo::findOrFail($id);
        /* Storage::disk('s3')->delete('Competencias/Escudos/' . $competencia->escudo); */
        Storage::delete($archivo->archivo);
        Archivo::destroy($id);
        
        return back()->with('message', 'Archivo eliminado');
    }
}
