<?php

namespace App\Models\Materias;

use App\Models\User;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class DocenteMateria extends Model
{
    use Uuids;

    protected $table = 'docentes_materias';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
