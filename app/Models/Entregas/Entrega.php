<?php

namespace App\Models\Entregas;

use App\Models\Archivos\Archivo;
use App\Models\Comentarios\Comentario;
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

    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'commentable')->orderBy('created_at', 'DESC');
    }

    public function obtenerInformacionParaLaNotificacion($id)
    {
        return Entrega::select('entregas.*', 'evaluaciones.id AS evaluacion_id', 'evaluaciones.nombre AS evaluacion', 
            'cursos.id AS curso_id', 'cursos.institucion_id', 'materias.id AS materia_id', 'materias.nombre AS materia')
            ->join('evaluaciones', 'entregas.evaluacion_id', 'evaluaciones.id')
            ->join('materias', 'evaluaciones.materia_id', 'materias.id')
            ->join('cursos', 'materias.curso_id', 'cursos.id')
            ->findOrFail($id);
    }
}
