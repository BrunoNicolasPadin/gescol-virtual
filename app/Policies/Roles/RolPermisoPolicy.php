<?php

namespace App\Policies\Roles;

use App\Models\Roles\PermisoRol;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolPermisoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->obtenerPermisos('Permiso de un rol: listar')) {
            return true;
        }
        return false;
    }

    public function view(User $user, PermisoRol $permisoRol)
    {
        //
    }

    public function create(User $user)
    {
        if ($user->obtenerPermisos('Permiso de un rol: crear')) {
            return true;
        }
        return false;
    }

    public function update(User $user, PermisoRol $permisoRol)
    {
        //
    }

    public function delete(User $user, PermisoRol $permisoRol)
    {
        if ($user->obtenerPermisos('Permiso de un rol: eliminar')) {
            return true;
        }
        return false;
    }

    public function restore(User $user, PermisoRol $permisoRol)
    {
        //
    }

    public function forceDelete(User $user, PermisoRol $permisoRol)
    {
        //
    }
}
