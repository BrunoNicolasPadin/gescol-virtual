<?php

namespace App\Policies\Evaluaciones;

use App\Models\Evaluaciones\Evaluacion;
use App\Models\Roles\RolUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluacionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, $materia_id)
    {
        if (RolUser::where('roles_users.user_id', $user->id)
            ->join('docentes_materias', 'roles_users.id', 'docentes_materias.rol_user_id')
            ->where('docentes_materias.materia_id', $materia_id)
            ->exists()) {
            return true;
        }
        if (RolUser::where('roles_users.user_id', $user->id)
            ->join('alumnos_materias', 'roles_users.id', 'alumnos_materias.rol_user_id')
            ->where('alumnos_materias.materia_id', $materia_id)
            ->exists()) {
            return true;
        }
        if ($user->obtenerPermisos('Evaluaciones: listar')) {
            return true;
        }
        return false;
    }

    public function view(User $user, Evaluacion $evaluacion)
    {
        if (RolUser::where('roles_users.user_id', $user->id)
            ->join('docentes_materias', 'roles_users.id', 'docentes_materias.rol_user_id')
            ->where('docentes_materias.materia_id', $evaluacion->id)
            ->exists()) {
            return true;
        }
        if (RolUser::where('roles_users.user_id', $user->id)
            ->join('alumnos_materias', 'roles_users.id', 'alumnos_materias.rol_user_id')
            ->where('alumnos_materias.materia_id', $evaluacion->id)
            ->exists()) {
            return true;
        }
        if ($user->obtenerPermisos('Evaluaciones: ver')) {
            return true;
        }
        return false;
    }

    public function create(User $user)
    {
        if ($user->obtenerPermisos('Evaluaciones: crear')) {
            return true;
        }
        return false;
    }

    public function update(User $user, Evaluacion $evaluacion)
    {
        if ($user->obtenerPermisos('Evaluaciones: editar')) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Evaluacion $evaluacion)
    {
        if ($user->obtenerPermisos('Evaluaciones: eliminar')) {
            return true;
        }
        return false;
    }

    public function restore(User $user, Evaluacion $evaluacion)
    {
        //
    }

    public function forceDelete(User $user, Evaluacion $evaluacion)
    {
        //
    }
}
