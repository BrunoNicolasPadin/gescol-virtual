<?php

namespace App\Policies\Evaluaciones;

use App\Models\Evaluaciones\Evaluacion;
use App\Models\Roles\RolUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluacionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, $materia_id)
    {
        return $this->verificarDocente(
            $user,
            $materia_id,
            'Evaluaciones: listar'
        );
    }

    public function view(User $user, Evaluacion $evaluacion)
    {
        return $this->verificarDocente(
            $user,
            $evaluacion->materia_id,
            'Evaluaciones: ver'
        );
    }

    public function create(User $user)
    {
        return $this->verificarPermiso($user, 'Evaluaciones: crear');
    }

    public function update(User $user)
    {
        return $this->verificarPermiso($user, 'Evaluaciones: editar');
    }

    public function delete(User $user)
    {
        return $this->verificarPermiso($user, 'Evaluaciones: eliminar');
    }

    public function verificarPermiso($user, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        return false;
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
}
