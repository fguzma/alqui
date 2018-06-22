<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddReserva extends FormRequest
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
            'Cedula_Cliente'=>'required|exists:cliente,Cedula_Cliente',
            'Nombre_Contacto'=>'required',
            'Fecha_Inicio'=>'required|date',
            'Fecha_Fin'=>'required|date',
            'Direccion_Local'=>'required',
        ];
    }
}
