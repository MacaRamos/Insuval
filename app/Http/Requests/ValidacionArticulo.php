<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionArticulo extends FormRequest
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
            'Art_cod' => 'required|max:15|unique:DBComercial.super_gc.ARTMAEST,Art_cod,' . $this->route('Art_cod') . ',Art_cod',
            'Art_nom_ex' => 'required|max:60',
            'Art_serie' => 'required|max:20',
            'ArtLote' => 'required|max:20',
            'Art_fecElab' => 'required|max:10',
            'Art_fecVenc' => 'required|max:10',
            'Art_horElab' => 'max:5',
            'Art_horVenc' => 'max:5',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'Art_cod.required' => 'El campo Código es requerido',
    //         'Art_nom_ex.required' => 'El campo Nombre es requerido',
    //         'Art_serie.required' => 'El campo Serie es requerido',
    //         'ArtLote.required' => 'El campo Lote es requerido',
    //         'Art_fecElab.required' => 'El campo F. Elab. es requerido',
    //         'Art_fecVenc.required' => 'El campo F. Venc. es requerido',
    //         'Art_horElab' => 'El campo debe ser en formato hh:mm',
    //         'Art_horVenc' => 'El campo debe ser en formato hh:mm',
    //     ];
    // }

    public function attributes()
    {
        return [
            'Art_cod' => 'Codigo',
            'Art_nom_ex' => 'Nombre',
            'Art_serie' => 'Serie',
            'ArtLote' => 'Lote',
            'Art_fecElab' => 'Fecha elaboración',
            'Art_fecVenc' => 'Fecha vencimiento',
            'Art_horElab' => 'Hora elaboración',
            'Art_horVenc' => 'Hora vencimiento'
        ];
    }
    // Rule::unique('DBComercial.super_gc.ARTMAEST', 'Art_cod')->ignore($this->route('Art_cod')),
}
