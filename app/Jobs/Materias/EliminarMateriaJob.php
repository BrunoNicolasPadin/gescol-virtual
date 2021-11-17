<?php

namespace App\Jobs\Materias;

use App\Models\Archivos\Archivo;
use App\Models\Clases\Clase;
use App\Models\Correcciones\Correccion;
use App\Models\Entregas\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use Illuminate\Bus\Queueable;
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
        $evaluaciones = Evaluacion::select('id')
            ->where('materia_id', $this->materia->id)
            ->get();

        foreach ($evaluaciones as $evaluacion) {
            $entregas = Entrega::where('evaluacion_id', $evaluacion->id)
                ->get();

            $this->eliminarEntregasCorrecciones($entregas);
            $this->eliminarArchivos($evaluacion->id);
            $evaluacion->delete();
        }
        $this->eliminarClases();
        $this->materia->delete();
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

    public function eliminarClases()
    {
        $clases = Clase::select('id')->where('materia_id', $this->materia->id)
            ->get();

        foreach ($clases as $clase) {
            $this->eliminarArchivos($clase->id);
            $clase->delete();
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
