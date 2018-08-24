<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class clienteAdd extends FormRequest
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
            'Cedula_Cliente'=>'required|unique:cliente',
            'Nombre'=>'required',
            'Apellido'=>'required',
            'Edad'=>'required|numeric',
            'Sexo'=>'required',
            'Direccion' => 'max:300'
        ];
    }
}
