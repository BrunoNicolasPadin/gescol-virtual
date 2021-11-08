<?php

namespace App\Models\Cursos;

use App\Models\Instituciones\Institucion;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use Uuids;

    protected $table = 'cursos';
    protected $fillable = [
        'nombre',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
}
