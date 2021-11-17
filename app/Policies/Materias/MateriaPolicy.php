<?php

namespace App\Policies\Materias;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MateriaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->verificarPermiso($user, 'Materias: listar');
    }

    public function create(User $user)
    {
        return $this->verificarPermiso($user, 'Materias: crear');
    }

    public function update(User $user)
    {
        return $this->verificarPermiso($user, 'Materias: editar');
    }

    public function delete(User $user)
    {
        return $this->verificarPermiso($user, 'Materias: eliminar');
    }

    public function verificarPermiso($user, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        return false;
    }
}
