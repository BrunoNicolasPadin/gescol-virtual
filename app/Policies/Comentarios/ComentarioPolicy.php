<?php

namespace App\Policies\Comentarios;

use App\Models\Comentarios\Comentario;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComentarioPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Comentario $comentario)
    {
        //
    }

    public function create(User $user, $type)
    {
        if ($type == 'App\Models\Evaluaciones\Evaluacion') {
            if ($user->obtenerPermisos('Comentarios en evaluaciones: crear')) {
                return true;
            }
            return false;
        }
        if ($type == 'App\Models\Entregas\Entrega') {
            if ($user->obtenerPermisos('Comentarios en entregas: crear')) {
                return true;
            }
            return false;
        }
        if ($type == 'App\Models\Clases\Clase') {
            if ($user->obtenerPermisos('Comentarios en clases: crear')) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function update(User $user, Comentario $comentario)
    {
        if ($user->id == $comentario->user_id) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Comentario $comentario)
    {
        if ($user->id == $comentario->user_id) {
            return true;
        }
        if ($comentario->commentable_type == 'App\Models\Evaluaciones\Evaluacion') {
            if ($user->obtenerPermisos('Comentarios en evaluaciones: eliminar')) {
                return true;
            }
            return false;
        }
        if ($comentario->commentable_type == 'App\Models\Entregas\Entrega') {
            if ($user->obtenerPermisos('Comentarios en entregas: eliminar')) {
                return true;
            }
            return false;
        }
        if ($comentario->commentable_type == 'App\Models\Clases\Clase') {
            if ($user->obtenerPermisos('Comentarios en clases: eliminar')) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function restore(User $user, Comentario $comentario)
    {
        //
    }

    public function forceDelete(User $user, Comentario $comentario)
    {
        //
    }
}
