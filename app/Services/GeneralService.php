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
}
