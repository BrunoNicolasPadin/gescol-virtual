<?php

namespace App\Http\Requests\Cursos;

use Illuminate\Foundation\Http\FormRequest;

class StoreCursoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cursos.*.nombre' => 'required|string|max:255',
        ];
    }
}
