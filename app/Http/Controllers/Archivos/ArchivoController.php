<?php

namespace App\Http\Controllers\Archivos;

use App\Http\Controllers\Controller;
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

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return Inertia::render('Archivos/Create', [
            'id' => $request->id,
            'type' => $request->type,
            'carpeta' => $request->carpeta,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        echo 'Archivo - Guardado';
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $archivo = Archivo::findOrFail($id);
        /* Storage::disk('s3')->delete('Competencias/Escudos/' . $competencia->escudo); */
        Storage::delete($archivo->archivo);
        Archivo::destroy($id);
        echo 'Archivo - Eliminado';
    }
}
