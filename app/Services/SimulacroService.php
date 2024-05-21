<?php

namespace App\Services;

use App\Interfaces\SimulacroRepository;

class SimulacroService
{
    protected $simulacroRepository;

    public function __construct(SimulacroRepository $simulacroRepository)
    {
        $this->simulacroRepository = $simulacroRepository;
    }

    public function getSimulacros()
    {
        return $this->simulacroRepository->getSimulacros();
    }

    public function getSimulacroById($id)
    {
        return $this->simulacroRepository->getSimulacroById($id);
    }

    public function getSesiones()
    {
        return $this->simulacroRepository->getSesiones();
    }

    public function getSesionById($sesion_id)
    {
        return $this->simulacroRepository->getSesionById($sesion_id);
    }

    public function getSesionMateria($sesion_id)
    {
        return $this->simulacroRepository->getSesionMateria($sesion_id);
    }

    public function getPreguntas($materia_id, $sesion_id)
    {
        return $this->simulacroRepository->getPreguntas($materia_id, $sesion_id);
    }

    public function getPreguntas2($materia_id, $numpre)
    {
        return $this->simulacroRepository->getPreguntas2($materia_id, $numpre);
    }

    public function getTotalPreguntas($materia_id)
    {
        return $this->simulacroRepository->getTotalPreguntas($materia_id);
    }

    public function getTotalMaterias($sesion_id)
    {
        return $this->simulacroRepository->getTotalMaterias($sesion_id);
    }

    public function getTotalSesionesMaterias()
    {
        return $this->simulacroRepository->getTotalSesionesMaterias();
    }

    public function createResultado(array $request)
    {
        return $this->simulacroRepository->createResultado($request);
    }

    public function verificarResultado(array $request)
    {
        return $this->simulacroRepository->verificarResultado($request);
    }

    public function verificarSesion(array $request)
    {
        return $this->simulacroRepository->verificarSesion($request);
    }

    public function verificarPuntaje(array $vector)
    {
        return $this->simulacroRepository->verificarPuntaje($vector);
    }

    public function getPuntaje(array $vector)
    {
        return $this->simulacroRepository->getPuntaje($vector);
    }

    public function getInstitucion()
    {
        return $this->simulacroRepository->getInstitucion();
    }

    public function createResultadoPreguntas(array $datos)
    {
        return $this->simulacroRepository->createResultadoPreguntas($datos);
    }

    public function getEstudiantesByResultado(array $datos)
    {
        return $this->simulacroRepository->getEstudiantesByResultado($datos);
    }

    public function totalSumPreguntas()
    {
        return $this->simulacroRepository->totalSumPreguntas();
    }

    public function getUsersSimulacrosByResultado(array $datos)
    {
        return $this->simulacroRepository->getUsersSimulacrosByResultado($datos);
    }

    public function getResultadoComponentes(array $vector)
    {
        return $this->simulacroRepository->getResultadoComponentes($vector);
    }

    public function getResultadoCompetencias(array $vector)
    {
        return $this->simulacroRepository->getResultadoCompetencias($vector);
    }

    public function getPuntajesMaximosMinimos(array $vector)
    {
        return $this->simulacroRepository->getPuntajesMaximosMinimos($vector);
    }

    public function getPuntajesMateriaEstudiante(array $vector)
    {
        return $this->simulacroRepository->getPuntajesMateriaEstudiante($vector);
    }

    public function getPuntajesTotalMaximosMinimos(array $vector)
    {
        return $this->simulacroRepository->getPuntajesTotalMaximosMinimos($vector);
    }

    public function getPuntajesTotalMaximosMinimosCursos(array $vector)
    {
        return $this->simulacroRepository->getPuntajesTotalMaximosMinimosCursos($vector);
    }

    public function getInstitucion2(array $vector)
    {
        return $this->simulacroRepository->getInstitucion2($vector);
    }
}
