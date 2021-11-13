<?php

namespace App\Policies\Clases;

use App\Models\Clases\Clase;
use App\Models\Roles\RolUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
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
        if ($user->obtenerPermisos('Clases: listar')) {
            return true;
        }
        return false;
    }

    public function view(User $user, Clase $clase)
    {
        if (RolUser::where('roles_users.user_id', $user->id)
            ->join('docentes_materias', 'roles_users.id', 'docentes_materias.rol_user_id')
            ->where('docentes_materias.materia_id', $clase->materia_id)
            ->exists()) {
            return true;
        }
        if (RolUser::where('roles_users.user_id', $user->id)
            ->join('alumnos_materias', 'roles_users.id', 'alumnos_materias.rol_user_id')
            ->where('alumnos_materias.materia_id', $clase->materia_id)
            ->exists()) {
            return true;
        }
        if ($user->obtenerPermisos('Clases: ver')) {
            return true;
        }
        return false;
    }

    public function create(User $user)
    {
        if ($user->obtenerPermisos('Clases: crear')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Clases\Clase  $clase
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Clase $clase)
    {
        if ($user->obtenerPermisos('Clases: editar')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Clases\Clase  $clase
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Clase $clase)
    {
        if ($user->obtenerPermisos('Clases: eliminar')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Clases\Clase  $clase
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Clase $clase)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Clases\Clase  $clase
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Clase $clase)
    {
        //
    }
}
