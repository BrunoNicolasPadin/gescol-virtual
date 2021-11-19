<?php

namespace App\Models\Materias;

use App\Models\Cursos\Curso;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use Uuids;
    use HasFactory;

    protected $table = 'materias';
    protected $fillable = [
        'nombre',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
