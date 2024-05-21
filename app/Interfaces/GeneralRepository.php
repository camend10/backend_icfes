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

    public function getPuntajesGlobalEstudiante(array $vector);

    public function getPuntajesGlobalInstitucion(array $vector);

    public function getPuntajesGlobalMateriasInstitucion(array $vector);

    public function getPuntajesGlobalMaximoMinimoInstitucion(array $vector);

    public function getPuntajeMaximoMinimoCurso(array $vector);

    public function getConsultaTotalPromedios(array $vector);

    public function getConsultaTotalPromedios2(array $vector);

    public function getResultadoComponentesGlobal(array $vector);

    public function getResultadoCompetenciasGlobal(array $vector);

    public function getPuntajesGlobalInstitucionPuestos(array $vector);

}
