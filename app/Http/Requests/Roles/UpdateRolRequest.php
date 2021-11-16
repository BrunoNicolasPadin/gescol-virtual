<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRolRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'claveDeAccesoVieja' => 'nullable|string|min:8|max:32',
            'claveDeAccesoNueva' => 'nullable|string|min:8|max:32|same:claveDeAccesoNueva_confirmation',
            'claveDeAccesoNueva_confirmation' => 'nullable|string|min:8|max:32',
        ];
    }
}
