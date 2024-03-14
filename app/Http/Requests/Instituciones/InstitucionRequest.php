<?php

namespace App\Http\Requests\Instituciones;

use Illuminate\Foundation\Http\FormRequest;

class InstitucionRequest extends FormRequest
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
                'codigo' => 'required|max:50|unique:instituciones,codigo',
                'nit' => 'required|max:50|unique:instituciones,nit',
                'nombre' => 'required|string|max:100',
                'email' => 'required|email|max:100|unique:instituciones,email',
                'direccion' => 'string|nullable',
                'telefono' => 'string|nullable',
                'departamento_id' => 'required',
                'municipio_id' => 'required',
                'user_id' => 'integer|nullable',
                'foto' => 'string|nullable',
                'estado' => 'integer|nullable'
            ],
            'PUT' =>  [
                'codigo' => 'required|max:50|unique:instituciones,codigo,' . $this->id,
                'nit' => 'required|max:50|unique:instituciones,nit,' . $this->id,
                'nombre' => 'required|string|max:100',
                'email' => 'required|email|max:100|unique:instituciones,email,' . $this->id,
                'direccion' => 'string|nullable',
                'telefono' => 'string|nullable',
                'departamento_id' => 'required',
                'municipio_id' => 'required',
                'user_id' => 'integer|nullable',
                'foto' => 'string|nullable',
                'estado' => 'integer|nullable',
            ],
        };
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El codigo es obligatorio',
            'codigo.unique' => 'El codigo ya existe',
            'codigo.max' => 'El maximo de caracteres del codigo es 50',
            'nit.required' => 'El nit es obligatorio',
            'nit.unique' => 'El nit ya existe',
            'nit.max' => 'El maximo de caracteres del nit es 50',
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.string' => 'El nombre debe ser una cadena de caracteres',
            'nombre.max' => 'El maximo de caracteres del nombre es 100',
            'email.email' => 'Correo no valido',
            'email.required' => 'El correo es obligatorio',
            'email.max' => 'El maximo de caracteres del email es 100',
            'email.unique' => 'El correo ya existe',
            'departamento_id.required' => 'El departamento es obligatorio',
            'municipio_id.required' => 'El municipio es obligatorio'
        ];
    }
}
