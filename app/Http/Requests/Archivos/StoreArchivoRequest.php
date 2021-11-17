<?php

namespace App\Http\Requests\Archivos;

use Illuminate\Foundation\Http\FormRequest;

class StoreArchivoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'archivo' => 'required|file',
        ];
    }
}
