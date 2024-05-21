<?php

namespace App\Services;

use App\Interfaces\GeneralRepository;

class GeneralService
{
    protected $generalRepository;

    public function __construct(GeneralRepository $generalRepository)
    {
        $this->generalRepository = $generalRepository;
    }


    public function getDepartamentos()
    {
        return $this->generalRepository->getDepartamentos();
    }

    public function getMunicipios()
    {
        return $this->generalRepository->getMunicipios();
    }

    public function getTipoDocs()
    {
        return $this->generalRepository->getTipoDocs();
    }

    public function cursos()
    {
        return $this->generalRepository->cursos();
    }

    public function grados()
    {
        return $this->generalRepository->grados();
    }

    public function simulacros()
    {
        return $this->generalRepository->simulacros();
    }

    public function sesiones()
    {
        return $this->generalRepository->sesiones();
    }

    public function componentes($materia_id)
    {
        return $this->generalRepository->componentes($materia_id);
    }

    public function getTotalPreguntas()
    {
        return $this->generalRepository->getTotalPreguntas();
    }

    public function competencias($materia_id)
    {
        return $this->generalRepository->competencias($materia_id);
    }

    public function getPuntajesGlobalEstudiante(array $vector)
    {
        return $this->generalRepository->getPuntajesGlobalEstudiante($vector);
    }

    public function getPuntajesGlobalInstitucion(array $vector)
    {
        return $this->generalRepository->getPuntajesGlobalInstitucion($vector);
    }

    public function getPuntajesGlobalMateriasInstitucion(array $vector)
    {
        return $this->generalRepository->getPuntajesGlobalMateriasInstitucion($vector);
    }

    public function getPuntajesGlobalMaximoMinimoInstitucion(array $vector)
    {
        return $this->generalRepository->getPuntajesGlobalMaximoMinimoInstitucion($vector);
    }

    public function getPuntajeMaximoMinimoCurso(array $vector)
    {
        return $this->generalRepository->getPuntajeMaximoMinimoCurso($vector);
    }

    public function getConsultaTotalPromedios(array $vector)
    {
        return $this->generalRepository->getConsultaTotalPromedios($vector);
    }

    public function getConsultaTotalPromedios2(array $vector)
    {
        return $this->generalRepository->getConsultaTotalPromedios2($vector);
    }

    public function getResultadoComponentesGlobal(array $vector)
    {
        return $this->generalRepository->getResultadoComponentesGlobal($vector);
    }

    public function getResultadoCompetenciasGlobal(array $vector)
    {
        return $this->generalRepository->getResultadoCompetenciasGlobal($vector);
    }

    public function getPuntajesGlobalInstitucionPuestos(array $vector)
    {
        return $this->generalRepository->getPuntajesGlobalInstitucionPuestos($vector);
    }
}
