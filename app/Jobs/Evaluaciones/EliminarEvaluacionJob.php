<?php

namespace App\Jobs\Evaluaciones;

use App\Models\Archivos\Archivo;
use App\Models\Correcciones\Correccion;
use App\Models\Entregas\Entrega;
use Illuminate\Bus\Queueable;
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
        $entregas = Entrega::where('evaluacion_id', $this->evaluacion->id)
            ->get();

        $this->eliminarEntregasCorrecciones($entregas);
        $this->eliminarArchivos($this->evaluacion->id);
        $this->evaluacion->delete();
    }

    public function eliminarEntregasCorrecciones($entregas)
    {
        foreach ($entregas as $entrega) {
            $correcciones = Correccion::where('entrega_id', $entrega->id)
                ->get();

            foreach ($correcciones as $correccion) {
                Storage::delete($correccion->archivo);
                $correccion->delete();
            }
            $this->eliminarArchivos($entrega->id);
            $entrega->delete();
        }
    }

    public function eliminarArchivos($fileable_id)
    {
        $archivos = Archivo::where('fileable_id', $fileable_id)
            ->get();

        foreach ($archivos as $archivo) {
            Storage::delete($archivo->archivo);
            $archivo->delete();
        }
    }
}
