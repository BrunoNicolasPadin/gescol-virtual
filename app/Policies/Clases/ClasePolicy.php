<?php

namespace App\Policies\Clases;

use App\Models\Clases\Clase;
use App\Models\Roles\RolUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, $materia_id)
    {
        return $this->verificarDocente(
            $user,
            $materia_id,
            'Clases: listar'
        );
    }

    public function view(User $user, Clase $clase)
    {
        return $this->verificarDocente(
            $user,
            $clase->materia_id,
            'Clases: ver'
        );
    }

    public function create(User $user)
    {
        return $this->verificarPermiso($user, 'Clases: crear');
    }

    public function update(User $user)
    {
        return $this->verificarPermiso($user, 'Clases: editar');
    }

    public function delete(User $user)
    {
        return $this->verificarPermiso($user, 'Clases: eliminar');
    }

    public function verificarDocente($user, $materia_id, $permiso)
    {
        if (RolUser::where('roles_users.user_id', $user->id)
            ->join(
                'docentes_materias',
                'roles_users.id',
                'docentes_materias.rol_user_id'
            )
            ->where('docentes_materias.materia_id', $materia_id)
            ->exists()) {
            return true;
        }
        return $this->verificarAlumno($user, $materia_id, $permiso);
    }

    public function verificarAlumno($user, $materia_id, $permiso)
    {
        if (RolUser::where('roles_users.user_id', $user->id)
            ->join(
                'alumnos_materias',
                'roles_users.id',
                'alumnos_materias.rol_user_id'
            )
            ->where('alumnos_materias.materia_id', $materia_id)
            ->exists()) {
            return true;
        }
        return $this->verificarPermiso($user, $permiso);
    }

    public function verificarPermiso($user, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        return false;
    }
}
