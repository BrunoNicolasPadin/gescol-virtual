<?php

namespace App\Policies\Cursos;

use App\Models\Cursos\Curso;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CursoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if ($user->obtenerPermisos('Cursos: listar')) {
            return true;
        }
        return false;
    }

    public function view(User $user, Curso $curso)
    {
        //
    }

    public function create(User $user)
    {
        if ($user->obtenerPermisos('Cursos: crear')) {
            return true;
        }
        return false;
    }

    public function update(User $user, Curso $curso)
    {
        if ($user->obtenerPermisos('Cursos: editar')) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Curso $curso)
    {
        if ($user->obtenerPermisos('Cursos: eliminar')) {
            return true;
        }
        return false;
    }
}
