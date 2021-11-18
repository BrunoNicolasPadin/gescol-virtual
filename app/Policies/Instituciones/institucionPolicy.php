<?php

namespace App\Policies\Instituciones;

use App\Models\Instituciones\Institucion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class institucionPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        if ($user->institucion === 0) {
            return false;
        }
        if ($user->institucion === 1
            && $user->verificarInstitucionCreada() === false) {
            return true;
        }
        return false;
    }

    public function edit(User $user, Institucion $institucion)
    {
        return $this->chequearUsuario($user, $institucion);
    }

    public function delete(User $user, Institucion $institucion)
    {
        return $this->chequearUsuario($user, $institucion);
    }

    public function chequearUsuario($user, $institucion)
    {
        if ($user->id === $institucion->user_id) {
            return true;
        }
        return false;
    }
}
