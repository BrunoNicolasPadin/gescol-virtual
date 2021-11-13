<?php

namespace App\Policies\Comentarios;

use App\Models\Comentarios\Respuesta;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RespuestaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Respuesta $respuesta)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Respuesta $respuesta)
    {
        if ($user->id == $respuesta->user_id) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Respuesta $respuesta)
    {
        if ($user->id == $respuesta->user_id) {
            return true;
        }
        if ($user->obtenerPermisos('Respuestas: eliminar')) {
            return true;
        }
        return false;
    }

    public function restore(User $user, Respuesta $respuesta)
    {
        //
    }

    public function forceDelete(User $user, Respuesta $respuesta)
    {
        //
    }
}
