<?php

namespace App\Interfaces;

interface MateriaRepository
{
    public function getMaterias();

    public function getMateriaById($id);

    public function getPreguntasMateria($txtbusqueda, $id);

    public function estadoPregunta($id, string $valor);

    public function getPreguntaById($id);

    public function createPregunta(array $pregunta);

    public function modifyPregunta(array $pregunta, $id);

    public function modifyPreguntaImagenes(array $pregunta, $id);
}
