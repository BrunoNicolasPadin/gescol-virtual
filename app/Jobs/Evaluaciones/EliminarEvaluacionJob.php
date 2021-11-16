<?php

namespace App\Jobs\Evaluaciones;

use App\Models\Archivos\Archivo;
use App\Models\Correcciones\Correccion;
use App\Models\Entregas\Entrega;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EliminarEvaluacionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $evaluacion;

    public function __construct($evaluacion)
    {
        $this->evaluacion = $evaluacion;
    }

    public function handle()
    {
        $entregas = Entrega::where('evaluacion_id', $this->evaluacion->id)->get();
        foreach ($entregas as $entrega) {
            
            $correcciones = Correccion::where('entrega_id', $entrega->id)->get();
            foreach ($correcciones as $correccion) {
                Storage::delete($correccion->archivo);
                $correccion->delete();
            }

            $archivosEntrega = Archivo::where('fileable_id', $entrega->id)->get();
            foreach ($archivosEntrega as $archivoEntrega) {
                Storage::delete($archivoEntrega->archivo);
                $archivoEntrega->delete();
            }
            $entrega->delete();
        }
        
        $archivosEvaluacion = Archivo::where('fileable_id', $this->evaluacion->id)->get();
        foreach ($archivosEvaluacion as $archivoEvaluacion) {
            Storage::delete($archivoEvaluacion->archivo);
            $archivoEvaluacion->delete();
        }
        $this->evaluacion->delete();
    }
}
