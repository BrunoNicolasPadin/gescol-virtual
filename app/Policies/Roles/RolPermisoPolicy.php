<?php

namespace App\Policies\Roles;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolPermisoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->verificarPermiso($user, 'Permisos de un rol: listar');
    }

    public function create(User $user)
    {
        return $this->verificarPermiso($user, 'Permisos de un rol: crear');
    }

    public function delete(User $user)
    {
        return $this->verificarPermiso($user, 'Permisos de un rol: eliminar');
    }

    public function verificarPermiso($user, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        return false;
    }
}
