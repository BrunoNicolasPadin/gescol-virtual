<?php

namespace App\Policies\Archivos;

use App\Models\Archivos\Archivo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArchivoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Archivo $archivo)
    {
        //
    }

    public function create(User $user, $type)
    {
        if ($type == 'App\Models\Evaluaciones\Evaluacion') {
            if ($user->obtenerPermisos('Archivos de evaluaciones: crear')) {
                return true;
            }
            return false;
        }
        if ($type == 'App\Models\Entregas\Entrega') {
            if ($user->obtenerPermisos('Archivos de entregas: crear')) {
                return true;
            }
            return false;
        }
        if ($type == 'App\Models\Clases\Clase') {
            if ($user->obtenerPermisos('Archivos de clases: crear')) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function update(User $user, Archivo $archivo)
    {
        //
    }

    public function delete(User $user, Archivo $archivo)
    {
        if ($archivo->fileable_type == 'App\Models\Evaluaciones\Evaluacion') {
            if ($user->obtenerPermisos('Archivos de evaluaciones: eliminar')) {
                return true;
            }
            return false;
        }
        if ($archivo->fileable_type == 'App\Models\Entregas\Entrega') {
            if ($user->obtenerPermisos('Archivos de entregas: eliminar')) {
                return true;
            }
            return false;
        }
        if ($archivo->fileable_type == 'App\Models\Clases\Clase') {
            if ($user->obtenerPermisos('Archivos de clases: eliminar')) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function restore(User $user, Archivo $archivo)
    {
        //
    }

    public function forceDelete(User $user, Archivo $archivo)
    {
        //
    }
}
