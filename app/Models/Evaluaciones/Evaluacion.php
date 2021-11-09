<?php

namespace App\Models\Evaluaciones;

use App\Models\Archivos\Archivo;
use App\Models\Materias\Materia;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use Uuids;

    protected $table = 'evaluaciones';
    protected $fillable = [
        'nombre',
        'descripcion',
        'fechaHoraComienzo',
        'fechaHoraFinalizacion',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'fileable');
    }
}
