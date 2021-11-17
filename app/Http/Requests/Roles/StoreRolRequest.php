<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreRolRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'roles.*.nombre' => 'required|string|max:255',
            'roles.*.claveDeAcceso' => 'required|string|min:8|max:32|same:claveDeAcceso_confirmation',
            'roles.*.claveDeAcceso_confirmation' => 'required|string|min:8|max:32',
        ];
    }
}
