<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionFormaFarmaceutica extends FormRequest
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
            'Pre_descripcion' => 'required|max:60',
            'Pre_unidadMedida' => 'required|max:10',
        ];
    }
    public function attributes()
    {
        return [
            'Pre_descripcion' => 'Descripción',
            'Pre_unidadMedida' => 'Unidad de médida'
        ];
    }
}
