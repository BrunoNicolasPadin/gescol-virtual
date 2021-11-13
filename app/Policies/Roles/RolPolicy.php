<?php

namespace App\Policies\Roles;

use App\Models\Roles\Rol;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Rol $rol)
    {
        //
    }

    public function create(User $user)
    {
        if ($user->obtenerPermisos('Roles: crear')) {
            return true;
        }
        return false;
    }

    public function update(User $user, $role)
    {
        if ($user->obtenerPermisos('Roles: editar')) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Rol $rol)
    {
        if ($user->obtenerPermisos('Roles: eliminar')) {
            return true;
        }
        return false;
    }
}
