<?php

namespace App\Interfaces;

interface SimulacroRepository
{
    public function getSimulacros();

    public function getSimulacroById($id);

    public function getSesiones();

    public function getSesionById($sesion_id);

    public function getSesionMateria($sesion_id);

    public function getPreguntas($materia_id, $sesion_id);

    public function getPreguntas2($materia_id, $numpre);

    public function getTotalPreguntas($materia_id);

    public function getTotalMaterias($sesion_id);

    public function getTotalSesionesMaterias();

    public function createResultado(array $resultado);

    public function verificarResultado(array $resultado);

    public function verificarSesion(array $resultado);

    public function verificarPuntaje(array $vector);

    public function getPuntaje(array $vector);

    public function getInstitucion();

    public function createResultadoPreguntas(array $datos);

    public function getEstudiantesByResultado(array $datos);

    public function totalSumPreguntas();

    public function getUsersSimulacrosByResultado(array $datos);

    public function getResultadoComponentes(array $vector);

    public function getResultadoCompetencias(array $vector);
}
