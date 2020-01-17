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
            'Rec_unidades' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'Rec_codigo.required' => 'Falta campo N° Receta, consulte a soporte',
            'SicFol.required' => 'Falta campo Folio',
            'PacID.required' => 'Falta campo Paciente',
            'IdPre.required' => 'Falta campo Prescriptor',
            'Mb_Cod_aux.required' => 'Falta campo Cliente',
            'Env_codigo.required' => 'Falta campo Envase',
            'Pre_codigo.required' => 'Falta campo Forma Farmacéutica',
            'Rec_cantidad.required' => 'Falta campo cantidad',
            'Rec_unidades.required' => 'Falta campo Unidades'
        ];
    }
}