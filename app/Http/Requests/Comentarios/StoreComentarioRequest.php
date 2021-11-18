<?php

namespace App\Http\Requests\Comentarios;

use Illuminate\Foundation\Http\FormRequest;

class StoreComentarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'contenido' => 'required|string|max:2500',
        ];
    }
}
