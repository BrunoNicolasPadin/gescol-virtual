<?php

namespace App\Models\Clases;

use App\Models\Archivos\Archivo;
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
}
