<?php

namespace App\Http\Requests;

use App\Rules\ValidarRUT;
use Illuminate\Foundation\Http\FormRequest;

class ValidacionPrescriptor extends FormRequest
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
            'PreRUT' => 'required|max:10',
            'PreDV' => 'required|max:1',
            'PreNom' => 'required|max:60',
        ];
    }
    public function attributes()
    {
        return [
            'PreRUT' => 'RUT',
            'PreDV' => 'DV',
            'PreNom' => 'Nombre',
        ];
    }

}
