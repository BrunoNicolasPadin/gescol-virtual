<?php

namespace App\Models\Clases;

use App\Models\Archivos\Archivo;
use App\Models\Comentarios\Comentario;
use App\Models\Materias\Materia;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use Uuids;

    protected $table = 'clases';
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'fileable');
    }

    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'commentable')
            ->orderBy('created_at', 'DESC');
    }

    public function obtenerInformacionParaLaNotificacion($id)
    {
        return Clase::select(
            'clases.*',
            'cursos.id AS curso_id',
            'cursos.institucion_id',
            'materias.id AS materia_id',
            'materias.nombre AS materia'
        )
            ->join('materias', 'clases.materia_id', 'materias.id')
            ->join('cursos', 'materias.curso_id', 'cursos.id')
            ->findOrFail($id);
    }
}
