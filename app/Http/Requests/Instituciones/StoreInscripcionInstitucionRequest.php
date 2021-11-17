<?php

namespace App\Http\Requests\Instituciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreInscripcionInstitucionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rol_id' => 'required|max:36|string',
            'claveDeAcceso' => 'required|min:8|max:32|string',
        ];
    }
}
