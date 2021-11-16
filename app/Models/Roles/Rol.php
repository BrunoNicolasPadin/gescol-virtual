<?php

namespace App\Models\Roles;

use App\Models\Instituciones\Institucion;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use Uuids;

    protected $table = 'roles';
    protected $fillable = [
        'nombre',
        'claveDeAcceso',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function permisosRol()
    {
        return $this->hasMany(PermisoRol::class);
    }
}
