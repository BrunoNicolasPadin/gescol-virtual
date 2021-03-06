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
        $this->authorize('create', [Archivo::class, $request->type]);

        return Inertia::render('Archivos/Create', [
            'id' => $request->id,
            'type' => $request->type,
            'carpeta' => $request->carpeta,
        ]);
    }

    public function store(StoreArchivoRequest $request)
    {
        $this->authorize('create', [Archivo::class, $request->type]);

        $archivo = new Archivo();
        $archivo->fileable_type = $request->type;
        $archivo->fileable_id = $request->id;

        $nombreArchivo = null;
        if ($request->hasFile('archivo')) {
            $carpeta = $request->carpeta;
            $nombreArchivo = $this->archivoService
                ->subirArchivo($request, $carpeta);
        }

        $archivo->archivo = $nombreArchivo;
        $archivo->save();

        return back()->with('message', 'Archivo guardado');
    }

    public function destroy(Archivo $archivo)
    {
        $this->authorize('delete', $archivo);

        Storage::delete($archivo->archivo);
        $archivo->delete();

        return back()->with('message', 'Archivo eliminado');
    }
}
