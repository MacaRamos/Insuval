<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionReceta extends FormRequest
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
            'Rec_codigo' => 'required|max:20',
            'SicFol' => 'required',
            'PacID' => 'required',
            'IdPre' => 'required',
            'Mb_Cod_aux' => 'required',
            'Env_codigo' => 'required',
            'Pre_codigo' => 'required',
            'Rec_cantidad' => 'required',
            'PrincipioActivo' => 'required|max:15',
            'Rec_unidades' => 'required',
            'Rec_indicacion' => 'max:40'
        ];
    }
    public function attributes()
    {
        return [
            'Rec_codigo.required' => 'Código',
            'SicFol.required' => 'Folio',
            'PacID.required' => 'Paciente',
            'IdPre.required' => 'Prescriptor',
            'Mb_Cod_aux.required' => 'Cliente',
            'Env_codigo.required' => 'Envase',
            'Pre_codigo.required' => 'Forma Farmacéutica',
            'Rec_cantidad.required' => 'Cantidad',
            'Rec_unidades.required' => 'Unidades',
            'Rec_indicacion' => 'Indicación'
        ];
    }
}