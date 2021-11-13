<?php

namespace App\Policies\Materias;

use App\Models\Materias\AlumnoMateria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlumnoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->obtenerPermisos('Alumnos de la materia: listar')) {
            return true;
        }
        return false;
    }

    public function view(User $user, AlumnoMateria $alumnoMateria)
    {
        //
    }

    public function create(User $user)
    {
        if ($user->obtenerPermisos('Alumnos de la materia: crear')) {
            return true;
        }
        return false;
    }

    public function update(User $user, AlumnoMateria $alumnoMateria)
    {
        if ($user->obtenerPermisos('Alumnos de la materia: editar')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Materias\AlumnoMateria  $alumnoMateria
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AlumnoMateria $alumnoMateria)
    {
        if ($user->obtenerPermisos('Alumnos de la materia: eliminar')) {
            return true;
        }
        return false;
    }

    public function restore(User $user, AlumnoMateria $alumnoMateria)
    {
        //
    }

    public function forceDelete(User $user, AlumnoMateria $alumnoMateria)
    {
        //
    }
}
