<?php

namespace App\Policies\Materias;

use App\Models\Materias\DocenteMateria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocentePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->obtenerPermisos('Docentes: listar')) {
            return true;
        }
        return false;
    }

    public function view(User $user, DocenteMateria $docenteMateria)
    {
        //
    }

    public function create(User $user)
    {
        if ($user->obtenerPermisos('Docentes: crear')) {
            return true;
        }
        return false;
    }

    public function update(User $user, DocenteMateria $docenteMateria)
    {
        if ($user->obtenerPermisos('Docentes: editar')) {
            return true;
        }
        return false;
    }

    public function delete(User $user, DocenteMateria $docenteMateria)
    {
        if ($user->obtenerPermisos('Docentes: eliminar')) {
            return true;
        }
        return false;
    }

    public function restore(User $user, DocenteMateria $docenteMateria)
    {
        //
    }

    public function forceDelete(User $user, DocenteMateria $docenteMateria)
    {
        //
    }
}
