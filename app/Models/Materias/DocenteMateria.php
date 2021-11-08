<?php

namespace App\Models\Materias;

use App\Models\Roles\RolUser;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class DocenteMateria extends Model
{
    use Uuids;

    protected $table = 'docentes_materias';

    public function rolUser()
    {
        return $this->belongsTo(RolUser::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
