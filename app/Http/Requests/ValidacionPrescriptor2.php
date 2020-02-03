<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionPrescriptor2 extends FormRequest
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
            'Mb_Cod_aux' => 'required|max:10|unique:DBFinanzas.super_fz.AUXILI,Mb_Cod_aux,' . $this->route('Mb_Cod_aux') . ',Mb_Cod_aux',
            'Mb_Dv_aux' => 'required|max:1',
            'Mb_Razon_a' => 'required|max:60'
        ];
    }
    public function attributes()
    {
        return [
            'Mb_Cod_aux' => 'RUT',
            'Mb_Dv_aux' => 'DV',
            'Mb_Razon_a' => 'Nombre',
        ];
    }
}
