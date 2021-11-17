<?php

namespace App\Observers\Instituciones;

use App\Models\Instituciones\Institucion;
use App\Models\Permisos\Permiso;
use App\Models\Roles\PermisoRol;
use App\Models\Roles\Rol;
use App\Models\Roles\RolUser;
use Illuminate\Support\Facades\Hash;

class InstitucionObserver
{
    public function created(Institucion $institucion)
    {
        $rol = new Rol();
        $rol->nombre = 'Institucion';
        $rol->claveDeAcceso =
            Hash::make(substr(base64_encode(mt_rand()), 0, 12));
        $rol->institucion()->associate($institucion->id);
        $rol->save();

        $permisos = Permiso::orderBy('nombre')->get();

        foreach ($permisos as $permiso) {
            $permisoRol = new PermisoRol();
            $permisoRol->rol()->associate($rol->id);
            $permisoRol->permiso()->associate($permiso->id);
            $permisoRol->save();
        }

        $rolUser = new RolUser();
        $rolUser->rol()->associate($rol->id);
        $rolUser->user()->associate($institucion->user_id);
        $rolUser->save();
    }

    /* public function updated(Institucion $institucion)
    {
    }

    public function deleted(Institucion $institucion)
    {
    }

    public function restored(Institucion $institucion)
    {
    }

    public function forceDeleted(Institucion $institucion)
    {
    } */
}
