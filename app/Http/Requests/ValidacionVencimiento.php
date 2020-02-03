<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionVencimiento extends FormRequest
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
            'Ven_codigo' => 'unique:VENCIMIENTO,Ven_codigo,' . $this->route('Ven_codigo') . ',Ven_codigo',
            'Ven_cantidad' => 'required|max:3',
            'Ven_tipo' => 'required',
        ];
    }
    public function attributes()
    {
        return [
            'Ven_codigo' => 'Código',
            'Ven_cantidad' => 'Cantidad',
            'Ven_tipo' => 'tipo',
        ];
    }
}
