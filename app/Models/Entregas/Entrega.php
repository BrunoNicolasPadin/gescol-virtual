<?php

namespace App\Models\Entregas;

use App\Models\Archivos\Archivo;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Materias\AlumnoMateria;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use Uuids;

    protected $table = 'entregas';
    protected $fillable = [
        'calificacion',
        'comentario',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }

    public function alumnoMateria()
    {
        return $this->belongsTo(AlumnoMateria::class);
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'fileable');
    }
}
