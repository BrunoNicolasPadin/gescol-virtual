<?php

namespace App\Policies\Cursos;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CursoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->verificarPermiso($user, 'Cursos: listar');
    }

    public function create(User $user)
    {
        return $this->verificarPermiso($user, 'Cursos: crear');
    }

    public function update(User $user)
    {
        return $this->verificarPermiso($user, 'Cursos: editar');
    }

    public function delete(User $user)
    {
        return $this->verificarPermiso($user, 'Cursos: eliminar');
    }

    public function verificarPermiso($user, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        return false;
    }
}
