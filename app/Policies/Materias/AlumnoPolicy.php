<?php

namespace App\Policies\Materias;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlumnoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->verificarPermiso($user, 'Alumnos de la materia: listar');
    }

    public function create(User $user)
    {
        return $this->verificarPermiso($user, 'Alumnos de la materia: crear');
    }

    public function update(User $user)
    {
        return $this->verificarPermiso($user, 'Alumnos de la materia: editar');
    }

    public function delete(User $user)
    {
        return $this->verificarPermiso(
            $user,
            'Alumnos de la materia: eliminar'
        );
    }

    public function verificarPermiso($user, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        return false;
    }
}
