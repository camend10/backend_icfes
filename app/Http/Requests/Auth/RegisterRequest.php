<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'POST' =>  [
                'tipo_doc_id' => 'required',
                'identificacion' => 'required|max:20|unique:users,identificacion',
                'name' => 'required|string|max:50',
                'email' => 'required|email|max:100|unique:users,email',
                'password' => 'required|string|min:8|max:30',
                'username' => 'required|max:20|unique:users,username',
                'direccion' => 'string|nullable',
                'telefono' => 'string|nullable',
                'role_id' => 'required',
                'departamento_id' => 'required',
                'municipio_id' => 'required',
                'curso_id' => 'integer|nullable',
                'grado_id' => 'integer|nullable',
                'tipo' => 'string|nullable',
                'estado' => 'integer|nullable',
                'codigo' => 'string|nullable',
                'jornada' => 'string|nullable',
                'fecha_nacimiento' => 'required',
                'user_id' => 'integer|nullable',
                'foto' => 'string|nullable',
                'genero' => 'string|nullable',
                'institucion_id' => 'integer|nullable',
            ],
            'PUT' =>  [
                'tipo_doc_id' => 'required',
                'identificacion' => 'required|max:20|unique:users,identificacion,' . $this->id,
                'name' => 'required|string|max:50',
                'email' => 'required|email|max:100|unique:users,email,' . $this->id,
                'username' => 'required|max:20|unique:users,username,' . $this->id,
                'direccion' => 'string|nullable',
                'telefono' => 'string|nullable',
                'role_id' => 'required',
                'departamento_id' => 'required',
                'municipio_id' => 'required',
                'curso_id' => 'integer|nullable',
                'grado_id' => 'integer|nullable',
                'tipo' => 'string|nullable',
                'estado' => 'integer|nullable',
                'codigo' => 'string|nullable',
                'jornada' => 'string|nullable',
                'fecha_nacimiento' => 'required',
                'user_id' => 'integer|nullable',
                'foto' => 'string|nullable',
                'genero' => 'string|nullable',
                'institucion_id' => 'integer|nullable',
            ],
        };
    }

    public function messages(): array
    {
        return [
            'tipo_doc_id.required' => 'El tipo de identificación es obligatorio',
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
            'password.required' => 'La clave es obligatoria',
            // 'password.confirmed' => 'Las claves no coinciden',
            'password.string' => 'La clave debe ser una cadena de caracteres',
            'password.max' => 'El maximo de caracteres de la clave es 30',
            'password.min' => 'El minimo de caracteres de la clave es 8',
            'username.required' => 'El username es obligatoria',
            'username.unique' => 'El username ya existe',
            'username.max' => 'El maximo de caracteres del username es 20',
            // 'password_confirmation.required' => 'Confirmar la clave es obligatorio',
            'role_id.required' => 'El rol es obligatorio',
            'departamento_id.required' => 'El departamento es obligatorio',
            'municipio_id.required' => 'El municipio es obligatorio',
            // 'curso_id.required' => 'El curso es obligatorio',
            // 'grado_id.required' => 'El grado es obligatorio',
            'tipo.required' => 'El tipo es obligatorio',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
        ];
    }
}
