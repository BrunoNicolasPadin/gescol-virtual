<?php

namespace App\Policies\Correcciones;

use App\Models\Correcciones\Correccion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CorreccionPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $this->verificarPermiso($user, 'Correcciones: creat');
    }

    public function delete(User $user)
    {
        return $this->verificarPermiso($user, 'Correcciones: eliminar');
    }

    public function verificarPermiso($user, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        return false;
    }
}
