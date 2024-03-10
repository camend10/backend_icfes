<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\Http\Request;

class GeneralController extends Controller
{

    protected $generalService;

    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
    }

    public function departamentos()
    {
        $departamentos = $this->generalService->getDepartamentos();

        return response()->json([
            'ok' => true,
            'departamentos' => $departamentos,
            'total' => $departamentos->count()
        ], 200);
    }

    public function municipios()
    {
        $muni = $this->generalService->getMunicipios();

        $municipios = [];
        foreach ($muni as $item) {
            $municipios[$item->departamento_id][] = [
                'id' => $item->id,
                'nombre' => strtoupper($item->nombre),
            ];
        }


        return response()->json([
            'ok' => true,
            'municipios' => $municipios,
            'total' => $muni->count()
        ], 200);
    }

    public function tipodocs()
    {
        $tipodocumentos = $this->generalService->getTipoDocs();

        return response()->json([
            'ok' => true,
            'tipodocumentos' => $tipodocumentos,
            'total' => $tipodocumentos->count()
        ], 200);
    }
}
