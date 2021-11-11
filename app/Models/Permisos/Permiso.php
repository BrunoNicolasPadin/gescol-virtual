<?php

namespace App\Models\Permisos;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use Uuids;

    protected $fillable = [
        'nombre',
    ];
}
