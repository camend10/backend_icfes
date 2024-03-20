<?php

namespace App\Repositories;

use App\Interfaces\MateriaRepository;
use App\Models\Departamento;
use App\Models\Materia;
use App\Models\Pregunta;

class MateriaRepositoryImpl implements MateriaRepository
{
    public function getMaterias()
    {
        return Materia::where('estado', 1)->get();
    }

    public function getPreguntasMateria($txtbusqueda, $id)
    {
        return Pregunta::when($txtbusqueda, function ($sql) use ($txtbusqueda) {
            $sql->where('que_desc', 'LIKE', '%' . $txtbusqueda . '%');
        })
            ->where('test_id', $id)
            ->get();
    }

    public function estadoPregunta($id, string $valor)
    {
        return Pregunta::where(['id' => $id])->update([
            'estado' => $valor
        ]);
    }

    public function getPreguntaById($id)
    {
        return Pregunta::where('id', $id)
            ->first();
    }

    public function getMateriaById($id)
    {
        return Materia::where('id', $id)
            ->first();
    }

    public function createPregunta(array $pregunta)
    {
        return Pregunta::create([
            "test_id" => $pregunta["test_id"],
            "que_desc" => $pregunta["que_desc"],
            "ans1" => $pregunta["ans1"],
            "ans2" => $pregunta["ans2"],
            "ans3" => $pregunta["ans3"],
            "ans4" => $pregunta["ans4"],
            "true_ans" => $pregunta["true_ans"],
            "simulacro" => $pregunta["simulacro"],
            "sesion" => $pregunta["sesion"],
            "componente" => $pregunta["componente"],
            "competencia" => $pregunta["competencia"],
            "que_desc2" => $pregunta["que_desc2"],
            "que_desc3" => $pregunta["que_desc3"],
            "pre_test" => $pregunta["pre_test"],
            "estado" => $pregunta["estado"],
            "user_id" => $pregunta["user_id"],
        ]);
    }

    public function modifyPregunta(array $pregunta, $id)
    {
        return Pregunta::whereId($id)->update($pregunta);
    }

    public function modifyPreguntaImagenes(array $pregunta, $id)
    {
        return Pregunta::whereId($id)->update([
            "img_preg" => $pregunta["img_preg"],
            "imgr1" => $pregunta["imgr1"],
            "imgr2" => $pregunta["imgr2"],
            "imgr3" => $pregunta["imgr3"],
            "imgr4" => $pregunta["imgr4"],
            "ban_img" => $pregunta["ban_img"],
            "ban_imgr1" => $pregunta["ban_imgr1"],
            "ban_imgr2" => $pregunta["ban_imgr2"],
            "ban_imgr3" => $pregunta["ban_imgr3"],
            "ban_imgr4" => $pregunta["ban_imgr4"]
        ]);
    }
}
