<?php

namespace App\Jobs\Materias;

use App\Models\Archivos\Archivo;
use App\Models\Clases\Clase;
use App\Models\Correcciones\Correccion;
use App\Models\Entregas\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EliminarMateriaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $materia;

    public function __construct($materia)
    {
        $this->materia = $materia;
    }

    public function handle()
    {
        //Evaluaciones, archivos, entregas, archivos, correcciones

        $evaluaciones = Evaluacion::select('id')->where('materia_id', $this->materia->id)->get();
        foreach ($evaluaciones as $evaluacion) {
            
            $entregas = Entrega::where('evaluacion_id', $evaluacion->id)->get();
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
            
            $archivosEvaluacion = Archivo::where('fileable_id', $evaluacion->id)->get();
            foreach ($archivosEvaluacion as $archivoEvaluacion) {
                Storage::delete($archivoEvaluacion->archivo);
                $archivoEvaluacion->delete();
            }
            $evaluacion->delete();
        }
        
        $clases = Clase::select('id')->where('materia_id', $this->materia->id)->get();
        foreach ($clases as $clase) {
            
            $archivosClase = Archivo::where('fileable_id', $clase->id)->get();
            foreach ($archivosClase as $archivoClase) {
                Storage::delete($archivoClase->archivo);
                $archivoClase->delete();
            }
            $clase->delete();
        }

        $this->materia->delete();
    }
}
