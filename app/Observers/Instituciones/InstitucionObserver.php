<?php

namespace App\Observers\Instituciones;

use App\Models\Instituciones\Institucion;
use App\Models\Permisos\Permiso;
use App\Models\Roles\PermisoRol;
use App\Models\Roles\Rol;
use App\Models\Roles\RolUser;

class InstitucionObserver
{
    /**
     * Handle the Institucion "created" event.
     *
     * @param  \App\Models\Instituciones\Institucion  $institucion
     * @return void
     */
    public function created(Institucion $institucion)
    {
        $rol = new Rol();
        $rol->nombre = 'Institucion';
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

    /**
     * Handle the Institucion "updated" event.
     *
     * @param  \App\Models\Instituciones\Institucion  $institucion
     * @return void
     */
    public function updated(Institucion $institucion)
    {
        //
    }

    /**
     * Handle the Institucion "deleted" event.
     *
     * @param  \App\Models\Instituciones\Institucion  $institucion
     * @return void
     */
    public function deleted(Institucion $institucion)
    {
        //
    }

    /**
     * Handle the Institucion "restored" event.
     *
     * @param  \App\Models\Instituciones\Institucion  $institucion
     * @return void
     */
    public function restored(Institucion $institucion)
    {
        //
    }

    /**
     * Handle the Institucion "force deleted" event.
     *
     * @param  \App\Models\Instituciones\Institucion  $institucion
     * @return void
     */
    public function forceDeleted(Institucion $institucion)
    {
        //
    }
}
