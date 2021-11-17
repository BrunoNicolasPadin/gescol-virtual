<?php

namespace App\Http\Requests\Materias;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocenteMateriaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'docentesMateria.*.docente_id' => 'required|max:36',
        ];
    }
}
