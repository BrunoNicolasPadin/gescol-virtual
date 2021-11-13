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
        if ($user->institucion == false) {
            return false;
        }
        if ($user->institucion == true && $user->verificarInstitucionCreada() == false) {
            return true;
        }
        return false;
    }

    public function edit(User $user, $institucione)
    {
        if ($user->id == $institucione->user_id) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Institucion $institucion)
    {
        if ($user->id == $institucion->user_id) {
            return true;
        }
        return false;
    }
}
