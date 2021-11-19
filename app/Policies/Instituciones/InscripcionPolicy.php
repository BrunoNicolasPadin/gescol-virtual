<?php

namespace App\Policies\Instituciones;

use App\Models\Roles\RolUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InscripcionPolicy
{
    use HandlesAuthorization;

    public function create(User $user, $institucion_id)
    {
        if (RolUser::where('user_id', $user->id)
            ->join('roles', 'roles_users.rol_id', 'roles.id')
            ->where('roles.institucion_id', $institucion_id)
            ->exists()) {
            return false;
        }
        return true;
    }

    public function update(User $user, RolUser $rolUser)
    {
        return $this->verificarPermiso($user, $rolUser, 'Inscripciones: editar');
    }

    public function delete(User $user, RolUser $rolUser)
    {
        return $this->verificarPermiso($user, $rolUser, 'Inscripciones: eliminar');
    }

    public function verificarPermiso($user, $rolUser, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        if ($user->id == $rolUser->user_id) {
            return true;
        }
        return false;
    }
}
