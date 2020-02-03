<?php

namespace App\Http\Requests;

use App\Rules\ValidarRUT;
use Illuminate\Foundation\Http\FormRequest;

class ValidacionPaciente extends FormRequest
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
            'PacRUT' => 'required|max:10',
            'PacDV' => 'required|max:1',
            'PacNom' => 'required|max:60',
        ];
    }
    public function attributes()
    {
        return [
            'PacRUT' => 'RUT',
            'PacDV' => 'DV',
            'PacNom' => 'Nombre',
        ];
    }

    
}
