<?php

namespace App\Interfaces;

interface GeneralRepository
{
    public function getDepartamentos();

    public function getMunicipios();

    public function getTipoDocs();

    public function cursos();

    public function grados();

    public function simulacros();

    public function sesiones();

    public function componentes($materia_id);

    public function getTotalPreguntas();

    public function competencias($materia_id);
}
