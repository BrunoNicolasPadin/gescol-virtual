<?php

namespace App\Models\Materias;

use App\Models\Roles\RolUser;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class AlumnoMateria extends Model
{
    use Uuids;

    protected $table = 'alumnos_materias';

    public function rolUser()
    {
        return $this->belongsTo(RolUser::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
