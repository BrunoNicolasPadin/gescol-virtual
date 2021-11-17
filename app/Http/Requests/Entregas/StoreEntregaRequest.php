<?php

namespace App\Http\Requests\Entregas;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntregaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'calificacion' => 'nullable|string|max:255',
            'comentario' => 'nullable|string|max:2500',
        ];
    }
}
