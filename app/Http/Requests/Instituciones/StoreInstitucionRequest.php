<?php

namespace App\Http\Requests\Instituciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstitucionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'claveDeAcceso' => 'required|string|min:8|max:32|same:claveDeAcceso_confirmation',
            'claveDeAcceso_confirmation' => 'required|string|min:8|max:32',
        ];
    }
}
