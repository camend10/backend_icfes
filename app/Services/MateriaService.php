<?php

namespace App\Services;

use App\Interfaces\MateriaRepository;

class MateriaService
{
    protected $materiaRepository;

    public function __construct(MateriaRepository $materiaRepository)
    {
        $this->materiaRepository = $materiaRepository;
    }

    public function getMaterias()
    {
        return $this->materiaRepository->getMaterias();
    }

    public function getMateriaById($id)
    {
        return $this->materiaRepository->getMateriaById($id);
    }

    public function getPreguntasMateria($txtbusqueda, $id)
    {
        return $this->materiaRepository->getPreguntasMateria($txtbusqueda, $id);
    }

    public function estadoPregunta(int $id, string $valor): int
    {
        return $this->materiaRepository->estadoPregunta($id, $valor);
    }

    public function getPreguntaById($id)
    {
        return $this->materiaRepository->getPreguntaById($id);
    }

    public function createPregunta(array $request)
    {
        $request['estado'] = 1;
        $request['user_id'] = auth()->user()->id;
        return $this->materiaRepository->createPregunta($request);
    }

    public function modifyPregunta(array $request, $id)
    {
        $request['user_id'] = auth()->user()->id;
        return $this->materiaRepository->modifyPregunta($request, $id);
    }

    public function modifyPreguntaImagenes(array $request, $id)
    {
        return $this->materiaRepository->modifyPreguntaImagenes($request, $id);
    }
}
