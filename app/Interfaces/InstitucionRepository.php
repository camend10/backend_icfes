<?php

namespace App\Interfaces;

interface InstitucionRepository
{
    public function getInstitucionAll();

    public function getInstitucionById($id);

    public function createInstitucion(array $institucion);

    public function estadoInstitucion($id, string $valor);

    public function updateImgById($id, string $filename);

    public function getInstituciones($txtbusqueda);

    public function modifyInstitucion(array $institucion, $id);
}
