<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionEquipo extends FormRequest
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
            'Equ_codigo' => 'unique:EQUIPO,Equ_codigo,' . $this->route('Equ_codigo') . ',Equ_codigo',
            'Equ_nombre' => 'required|max:40',
        ];
    }
    public function attributes()
    {
        return [
            'Equ_nombre' => 'Nombre',
        ];
    }
}
