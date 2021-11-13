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
        if ($user->obtenerPermisos('Entregas: listar')) {
            return true;
        }
        return false;
    }

    public function view(User $user, Entrega $entrega)
    {
        if (AlumnoMateria::where('alumnos_materias.id', $entrega->alumno_materia_id)
            ->join('roles_users', 'alumnos_materias.rol_user_id', 'roles_users.id')
            ->where('roles_users.user_id', $user->id)
            ->exists()) {
            return true;
        }
        if ($user->obtenerPermisos('Entregas: ver')) {
            return true;
        }
        return false;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Entrega $entrega)
    {
        if ($user->obtenerPermisos('Entregas: editar')) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Entrega $entrega)
    {
        return true;
    }

    public function restore(User $user, Entrega $entrega)
    {
        //
    }

    public function forceDelete(User $user, Entrega $entrega)
    {
        //
    }
}
