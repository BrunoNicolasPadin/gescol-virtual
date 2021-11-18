<?php

namespace App\Policies\Archivos;

use App\Models\Archivos\Archivo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArchivoPolicy
{
    use HandlesAuthorization;

    protected $models = [
        'App\Models\Evaluaciones\Evaluacion',
        'App\Models\Entregas\Entrega',
        'App\Models\Clases\Clase',
    ];

    protected $permisosCrear = [
        'Archivos de evaluaciones: crear',
        'Archivos de entregas: crear',
        'Archivos de clases: crear',
    ];

    protected $permisosEliminar = [
        'Archivos de evaluaciones: eliminar',
        'Archivos de entregas: eliminar',
        'Archivos de clases: eliminar',
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

    public function delete(User $user, Archivo $archivo)
    {
        return $this->verificarType(
            $archivo->fileable_type,
            $user,
            $this->models,
            $this->permisosEliminar
        );
    }

    public function verificarType($fileable_type, $user, $models, $permisos)
    {
        for ($i = 0; $i < count($models); $i++) {
            if ($fileable_type === $models[$i]) {
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
