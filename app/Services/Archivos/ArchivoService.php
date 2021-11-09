<?php

namespace App\Services\Archivos;

use Illuminate\Support\Facades\Storage;

class ArchivoService
{
    public function subirArchivo($request, $carpeta)
    {
        $archivo = $request->file('archivo');
        $unique = substr(base64_encode(mt_rand()), 0, 6);
        $nombreArchivo = $unique . '-' . $archivo->getClientOriginalName();
        /* $request->file('archivo')->storePubliclyAs($carpeta, $nombreArchivo, 's3'); */
        $archivo->storeAs($carpeta, $nombreArchivo);
        Storage::disk('public')->put($nombreArchivo, $carpeta);
        return $nombreArchivo;
    }

    public function subirArchivoArray($archivo, $carpeta)
    {
        $unique = substr(base64_encode(mt_rand()), 0, 6);
        $nombreArchivo = $unique . '-' . $archivo->getClientOriginalName();
        $archivo->storeAs($carpeta, $nombreArchivo, 's3');
        /* $archivo->storeAs($carpeta, $nombreArchivo); */
        return $nombreArchivo;
    }
}
