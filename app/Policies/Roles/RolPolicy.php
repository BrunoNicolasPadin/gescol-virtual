<?php

namespace App\Policies\Roles;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $this->verificarPermiso($user, 'Roles: crear');
    }

    public function update(User $user)
    {
        return $this->verificarPermiso($user, 'Roles: editar');
    }

    public function delete(User $user)
    {
        return $this->verificarPermiso($user, 'Roles: eliminar');
    }

    public function verificarPermiso($user, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        return false;
    }
}
