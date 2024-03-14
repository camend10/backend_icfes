<?php

namespace App\Services;

use App\Interfaces\InstitucionRepository;

class InstitucionService
{
    protected $institucionRepository;

    public function __construct(InstitucionRepository $institucionRepository)
    {
        $this->institucionRepository = $institucionRepository;
    }

    public function getInstitucionById($id)
    {
        return $this->institucionRepository->getInstitucionById($id);
    }

    public function createInstitucion(array $request)
    {
        $request['estado'] = 1;
        $request['user_id'] = auth()->user()->id;
        return $this->institucionRepository->createInstitucion($request);
    }

    public function modifyInstitucion(array $request, $id)
    {
        $request['user_id'] = auth()->user()->id;
        return $this->institucionRepository->modifyInstitucion($request, $id);
    }

    public function estadoInstitucion(int $id, string $valor): int
    {
        return $this->institucionRepository->estadoInstitucion($id, $valor);
    }

    public function updateImgById($id, string $filename)
    {
        return $this->institucionRepository->updateImgById($id, $filename);
    }

    public function getInstituciones($txtbusqueda)
    {
        return $this->institucionRepository->getInstituciones($txtbusqueda);
    }
}
