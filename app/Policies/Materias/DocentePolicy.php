<?php

namespace App\Policies\Materias;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocentePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->verificarPermiso($user, 'Docentes: listar');
    }

    public function create(User $user)
    {
        return $this->verificarPermiso($user, 'Docentes: crear');
    }

    public function update(User $user)
    {
        return $this->verificarPermiso($user, 'Docentes: editar');
    }

    public function delete(User $user)
    {
        return $this->verificarPermiso($user, 'Docentes: eliminar');
    }

    public function verificarPermiso($user, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        return false;
    }
}
