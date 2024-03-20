<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instituciones\InstitucionRequest;
use App\Models\Institucion;
use App\Services\InstitucionService;
use Illuminate\Http\Request;

class InstitucionController extends Controller
{
    protected $institucionService;

    public function __construct(InstitucionService $institucionService)
    {
        $this->institucionService = $institucionService;
    }

    public function index()
    {
        $txtbusqueda = request()->get('txtbusqueda');
        $instituciones = $this->institucionService->getInstituciones($txtbusqueda);
        if ($instituciones) {
            return response()->json([
                'ok' => true,
                'instituciones' => $instituciones,
                'total' => $instituciones->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function create(InstitucionRequest $request)
    {
        $institucion = $this->institucionService->createInstitucion($request->validated());
        if ($institucion) {
            return response()->json([
                'ok' => true,
                'institucion' => $institucion
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "La institución no fue creada"
            ], 500);
        }
    }

    public function modify(InstitucionRequest $request, $id)
    {
        if (auth()->user()->role_id != 1) {
            return response()->json([
                'ok' => false,
                'errors' => "El usuario no tiene permisos para realizar esta operación"
            ], 500);
        }

        $institucion = $this->institucionService->modifyInstitucion($request->validated(), $id);
        if ($institucion) {
            $institucion = $this->institucionService->getInstitucionById($id);
            return response()->json([
                'ok' => true,
                'institucion' => $institucion
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "La institución no fue modificada"
            ], 500);
        }
    }

    public function upload(Request $request)
    {

        $data = $request->all();

        if (isset($data["archivo"])) {
            $filename = time() . "_" . $data["id"] . "_logo." . $data["archivo"]->extension();

            $carpeta1 = glob(public_path('imagenes/instituciones/' . $data["id"] . "/*"));
            foreach ($carpeta1 as $archivo) {
                if (is_file($archivo)) {
                    unlink($archivo);
                }
            }
            $mover = $request->archivo->move(public_path('imagenes/instituciones/' . $data["id"]), $filename);

            if ($mover) {
                $institucion = $this->institucionService->updateImgById($data["id"], $filename);
                if ($institucion) {
                    $institucion = $this->institucionService->getInstitucionById($data["id"]);
                    return response()->json([
                        'ok' => true,
                        'institucion' => $institucion,
                    ], 200);
                } else {
                    return response()->json([
                        'ok' => false,
                        'errors' => "La imagen no fue subida"
                    ], 500);
                }
            } else {
                return response()->json([
                    'ok' => false,
                    'errors' => "La imagen no fue subida"
                ], 500);
            }
        }
    }

    public function estado()
    {

        if (auth()->user()->role_id != 1) {
            return response()->json([
                'ok' => false,
                'errors' => "El usuario no tiene permisos para realizar esta operación"
            ], 500);
        }

        $id = request()->get('id');
        $estado = request()->get('estado');

        if ($estado == 1) {
            $mensaje = "Institución eliminada de manera exitosa";
            $valor = 0;
        } else {
            $mensaje = "Institución activada de manera exitosa";
            $valor = 1;
        }

        $institucion = $this->institucionService->estadoInstitucion($id, $valor);
        if ($institucion) {
            $institucion = $this->institucionService->getInstitucionById($id);
            return response()->json([
                'ok' => true,
                'institucion' => $institucion,
                'mensaje' => $mensaje
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function byid()
    {
        $id = request()->get('id');
        $institucion = $this->institucionService->getInstitucionById($id);
        if ($institucion) {
            return response()->json([
                'ok' => true,
                'institucion' => $institucion
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "No existe institución con este id: " . $id
            ], 500);
        }
    }

    public function activas()
    {
        $instituciones = $this->institucionService->getActivas();
        if ($instituciones) {
            return response()->json([
                'ok' => true,
                'instituciones' => $instituciones
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }
}
