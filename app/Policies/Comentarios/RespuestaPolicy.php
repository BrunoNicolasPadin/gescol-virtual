<?php

namespace App\Policies\Comentarios;

use App\Models\Comentarios\Respuesta;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RespuestaPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Respuesta $respuesta)
    {
        return $this->verificarUsuario(
            $user,
            $respuesta,
            'Respuestas: editar'
        );
    }

    public function delete(User $user, Respuesta $respuesta)
    {
        return $this->verificarUsuario(
            $user,
            $respuesta,
            'Respuestas: eliminar'
        );
    }

    public function verificarUsuario($user, $respuesta, $permiso)
    {
        if ($user->id == $respuesta->user_id) {
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
