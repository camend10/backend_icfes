<?php

namespace App\Http\Requests\Preguntas;

use Illuminate\Foundation\Http\FormRequest;

class PreguntaRequest extends FormRequest
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
        // dd($this->que_desc);die;
        return match ($this->method()) {
            'POST' =>  [
                'id' => 'required',
                'test_id' => 'required',
                'que_desc' => 'required',
                'ans1' => 'required',
                'ans2' => 'required',
                'ans3' => 'required',
                'ans4' => 'required',
                'true_ans' => 'required',
                'img_preg' => 'nullable',
                'imgr1' => 'nullable',
                'imgr2' => 'nullable',
                'imgr3' => 'nullable',
                'imgr4' => 'nullable',
                'sesion' => 'required',
                'simulacro' => 'required',
                'componente' => 'required',
                'competencia' => 'string|nullable',
                'que_desc2' => 'string|nullable',
                'que_desc3' => 'string|nullable',
                'pre_test' => 'integer|nullable',
                'estado' => 'integer|nullable',
                'user_id' => 'integer|nullable',
                'ban_img' => 'integer|nullable',
                'ban_imgr1' => 'integer|nullable',
                'ban_imgr2' => 'integer|nullable',
                'ban_imgr3' => 'integer|nullable',
                'ban_imgr4' => 'integer|nullable'
            ],
            'PUT' =>  [
                'id' => 'required|nullable',
                'test_id' => 'required',
                'que_desc' => 'required',
                'ans1' => 'required',
                'ans2' => 'required',
                'ans3' => 'required',
                'ans4' => 'required',
                'true_ans' => 'required',
                'img_preg' => 'nullable',
                'imgr1' => 'nullable',
                'imgr2' => 'nullable',
                'imgr3' => 'nullable',
                'imgr4' => 'nullable',
                'sesion' => 'required',
                'simulacro' => 'required',
                'componente' => 'required',
                'competencia' => 'string|nullable',
                'que_desc2' => 'string|nullable',
                'que_desc3' => 'string|nullable',
                'pre_test' => 'integer|nullable',
                'estado' => 'integer|nullable',
                'user_id' => 'integer|nullable',
                'ban_img' => 'integer|nullable',
                'ban_imgr1' => 'integer|nullable',
                'ban_imgr2' => 'integer|nullable',
                'ban_imgr3' => 'integer|nullable',
                'ban_imgr4' => 'integer|nullable'
            ],
        };
    }

    public function messages(): array
    {
        return [
            'test_id.required' => 'El id de la materia es obligatorio',
            'que_desc.required' => 'La pregunta es obligatoria',
            'ans1.required' => 'La respuesta 1 es obligatoria',
            'ans2.required' => 'La respuesta 2 es obligatoria',
            'ans3.required' => 'La respuesta 3 es obligatoria',
            'ans4.required' => 'La respuesta 4 es obligatoria',
            'true_ans.required' => 'La respuesta verdadera es obligatoria',
            'sesion.required' => 'La sesión es obligatoria',
            'simulacro.required' => 'El simulacro es obligatorio',
            'componente.required' => 'El componente es obligatorio'
        ];
    }
}
