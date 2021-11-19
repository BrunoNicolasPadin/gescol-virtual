<?php

namespace App\Models\Cursos;

use App\Models\Instituciones\Institucion;
use App\Models\Materias\Materia;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use Uuids;
    use HasFactory;

    protected $table = 'cursos';
    protected $fillable = [
        'nombre',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function materias()
    {
        return $this->hasMany(Materia::class, 'curso_id');
    }
}
