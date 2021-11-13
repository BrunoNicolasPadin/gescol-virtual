<?php

namespace App\Policies\Materias;

use App\Models\Materias\Materia;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MateriaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->obtenerPermisos('Materias: listar')) {
            return true;
        }
        return false;
    }

    public function view(User $user, Materia $materia)
    {
        //
    }

    public function create(User $user)
    {
        if ($user->obtenerPermisos('Materias: crear')) {
            return true;
        }
        return false;
    }

    public function update(User $user, Materia $materia)
    {
        if ($user->obtenerPermisos('Materias: editar')) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Materia $materia)
    {
        if ($user->obtenerPermisos('Materias: eliminar')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Materias\Materia  $materia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Materia $materia)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Materias\Materia  $materia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Materia $materia)
    {
        //
    }
}
