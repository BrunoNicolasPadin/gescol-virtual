<?php

namespace App\Models\Roles;

use App\Models\Permisos\Permiso;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoRol extends Model
{
    use Uuids;
    use HasFactory;

    protected $table = 'permisos_roles';
    
    public function permiso()
    {
        return $this->belongsTo(Permiso::class);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
}
