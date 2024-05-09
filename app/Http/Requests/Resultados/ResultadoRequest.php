<?php

namespace App\Http\Requests\Resultados;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResultadoRequest extends FormRequest
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
                'materia_id' => [
                    'required',
                    Rule::unique('resultados')->where(function ($query) {
                        return $query->where('materia_id', request('materia_id'))
                            ->where('simulacro_id', request('simulacro_id'))
                            ->where('sesion_id', request('sesion_id'))
                            ->where('user_id', request('user_id'));
                    })
                ],
                'simulacro_id' => 'required',
                'sesion_id' => 'required',
                'user_id' => 'required',
                'correctas' => 'required',
                'respCorreptasIds' => 'nullable',
                'respCorreptasIdsValues' => 'nullable'
            ]
        };
    }

    public function messages(): array
    {
        return [
            'materia_id.unique' => 'El estudiante ya realizó esta prueba',
            'materia_id.required' => 'La materia es obligatoria',
            'simulacro_id.required' => 'El simulacro es obligatorio',
            'sesion_id.required' => 'La sesión es obligatoria',
            'user_id.required' => 'El usuario es obligatorio',
            'correctas.required' => 'Las respuestas correctas són obligatorias',
        ];
    }
}
