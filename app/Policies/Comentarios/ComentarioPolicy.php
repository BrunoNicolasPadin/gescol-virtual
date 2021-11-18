<?php

namespace App\Policies\Comentarios;

use App\Models\Comentarios\Comentario;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComentarioPolicy
{
    use HandlesAuthorization;

    protected $models = [
        'App\Models\Evaluaciones\Evaluacion',
        'App\Models\Entregas\Entrega',
        'App\Models\Clases\Clase',
    ];

    protected $permisosCrear = [
        'Comentarios en evaluaciones: crear',
        'Comentarios en entregas: crear',
        'Comentarios en clases: crear',
    ];

    protected $permisosEliminar = [
        'Comentarios en evaluaciones: eliminar',
        'Comentarios en entregas: eliminar',
        'Comentarios en clases: eliminar',
    ];

    public function create(User $user, $type)
    {
        return $this->verificarType(
            $type,
            $user,
            $this->models,
            $this->permisosCrear
        );
    }

    public function update(User $user, Comentario $comentario)
    {
        if ($user->id === $comentario->user_id) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Comentario $comentario)
    {
        if ($user->id === $comentario->user_id) {
            return true;
        }

        return $this->verificarType(
            $comentario->commentable_type,
            $user,
            $this->models,
            $this->permisosEliminar
        );
    }

    public function verificarType($comentario_type, $user, $models, $permisos)
    {
        for ($i = 0; $i < count($models); $i++) {
            if ($comentario_type === $models[$i]) {
                return $this->verificarPermiso($user, $permisos[$i]);
            }
        }
        return false;
    }

    public function verificarPermiso($user, $permiso)
    {
        if ($user->obtenerPermisos($permiso)) {
            return true;
        }
        return false;
    }
}
