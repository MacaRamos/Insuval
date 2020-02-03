<?php

namespace App\Http\Requests;

use App\Rules\ValidarRUT;
use Illuminate\Foundation\Http\FormRequest;

class ValidacionFuncionario extends FormRequest
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
            'rut' => ['required', new ValidarRUT],
            'Fun_rut' => 'required|max:10',
            'Fun_dv' => 'required|max:1',
            'Fun_nombre' => 'required|max:70',
            'Fun_apellido' => 'required|max:70'
        ];
    }
    public function attributes()
    {
        return [
            'Fun_rut' => 'RUT',
            'Fun_dv' => 'DV',
            'Fun_nombre' => 'Nombre',
            'Fun_apellido' => 'Apellido'
        ];
    }
}
