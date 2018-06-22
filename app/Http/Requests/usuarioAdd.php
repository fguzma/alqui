<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class usuarioAdd extends FormRequest
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
            'Usuario'=>'required|unique:users,name',
            'contraseña'=>'required|min:6',
            'correo'=>'required|E-mail|unique:users,email',
            'identificacion'=>'max:30',
        ];
    }
}
