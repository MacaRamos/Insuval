<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionPrecaucion extends FormRequest
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
            'Cau_codigo' => 'unique:precaucion,Cau_codigo,' . $this->route('Cau_codigo') . ',Cau_codigo',
            'Cau_descripcion' => 'required|max:40',
        ];
    }
    public function attributes()
    {
        return [
            'Cau_descripcion' => 'Descripción',
        ];
    }
}
