<?php

namespace App\Policies\Entregas;

use App\Models\Entregas\Entrega;
use App\Models\Materias\AlumnoMateria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntregaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->verificarPermiso($user, 'Entregas: listar');
    }

    public function view(User $user, Entrega $entrega)
    {
        if (AlumnoMateria::where(
            'alumnos_materias.id',
            $entrega->alumno_materia_id
        )
            ->join(
                'roles_users',
                'alumnos_materias.rol_user_id',
                'roles_users.id'
            )
            ->where('roles_users.user_id', $user->id)
            ->exists()) {
            return true;
        }
        return $this->verificarPermiso($user, 'Entregas: ver');
    }

    public function update(User $user)
    {
        return $this->verificarPermiso($user, 'Entregas: editar');
    }

    public function verificarPermiso($user, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        return false;
    }
}
