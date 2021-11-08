<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        if (Auth::user()->institucion) {
            return redirect(route('instituciones.create'));
        }
        return redirect(route('instituciones.mostrarBuscador'));
    }
}
