<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return match ($this->method()) {

            'PUT' =>  [
                'identificacion' => 'required|max:20|unique:users,identificacion,' . $this->id,
                'name' => 'required|string|max:50',
                'email' => 'required|email|max:100|unique:users,email,' . $this->id,
                'username' => 'required|max:20|unique:users,username,' . $this->id,
                'direccion' => 'string|nullable',
                'telefono' => 'string|nullable',
                'fecha_nacimiento' => 'required',
            ],
        };
    }

    public function messages(): array
    {
        return [
            'identificacion.required' => 'La identificación es obligatoria',
            'identificacion.unique' => 'La identificación ya existe',
            'identificacion.max' => 'El maximo de caracteres de la identificacion es 20',
            'name.required' => 'El nombre es obligatorio',
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El maximo de caracteres del nombre es 50',
            'email.email' => 'Correo no valido',
            'email.required' => 'El correo es obligatorio',
            'email.max' => 'El maximo de caracteres del email es 100',
            'email.unique' => 'El correo ya existe',
            'username.required' => 'El username es obligatoria',
            'username.unique' => 'El username ya existe',
            'username.max' => 'El maximo de caracteres del username es 20',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
        ];
    }
}
