<?php

namespace App\Policies\Correcciones;

use App\Models\Correcciones\Correccion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CorreccionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Correccion $correccion)
    {
        //
    }

    public function create(User $user)
    {
        if ($user->obtenerPermisos('Correcciones: crear')) {
            return true;
        }
        return false;
    }

    public function update(User $user, Correccion $correccion)
    {
        //
    }

    public function delete(User $user, Correccion $correccion)
    {
        if ($user->obtenerPermisos('Correcciones: eliminar')) {
            return true;
        }
        return false;
    }

    public function restore(User $user, Correccion $correccion)
    {
        //
    }

    public function forceDelete(User $user, Correccion $correccion)
    {
        //
    }
}
