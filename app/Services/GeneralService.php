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
}
