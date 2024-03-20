<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Preguntas\PreguntaRequest;
use App\Services\MateriaService;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    protected $materiaService;

    public function __construct(MateriaService $materiaService)
    {
        $this->materiaService = $materiaService;
    }

    public function materias()
    {
        $materias = $this->materiaService->getMaterias();
        if ($materias) {
            return response()->json([
                'ok' => true,
                'materias' => $materias,
                'total' => $materias->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
        }
    }

    public function preguntasMateria()
    {
        $txtbusqueda = request()->get('txtbusqueda');
        $id = request()->get('id');
        $preguntas = $this->materiaService->getPreguntasMateria($txtbusqueda, $id);
        if ($preguntas) {
            $materia = $this->materiaService->getMateriaById($id);
            return response()->json([
                'ok' => true,
                'preguntas' => $preguntas,
                'materia' => $materia,
                'total' => $preguntas->count()
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "Lo sentimos, ocurrió un error en el servidor: ",
            ], 500);
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
            $mensaje = "Pregunta eliminada de manera exitosa";
            $valor = 0;
        } else {
            $mensaje = "Pregunta activada de manera exitosa";
            $valor = 1;
        }

        $pregunta = $this->materiaService->estadoPregunta($id, $valor);
        if ($pregunta) {
            $pregunta = $this->materiaService->getPreguntaById($id);
            return response()->json([
                'ok' => true,
                'pregunta' => $pregunta,
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
        $pregunta = $this->materiaService->getPreguntaById($id);
        if ($pregunta) {
            return response()->json([
                'ok' => true,
                'pregunta' => $pregunta
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "No existe pregunta con este id: " . $id
            ], 500);
        }
    }

    public function create(PreguntaRequest $request)
    {

        $data = $request->validated();

        if ($data["competencia"] == null || $data["competencia"] == '' || $data["competencia"] == 'null') {
            $data["competencia"] = '';
        }
        if ($data["que_desc2"] == null || $data["que_desc2"] == '' || $data["que_desc2"] == 'null') {
            $data["que_desc2"] = '';
        }
        if ($data["que_desc3"] == null || $data["que_desc3"] == '' || $data["que_desc3"] == 'null') {
            $data["que_desc3"] = '';
        }

        $pregunta = $this->materiaService->createPregunta($data);
        if ($pregunta) {

            $data["id"] = $pregunta->id;

            if ($data["ban_img"] == "1") {
                if ($request->hasFile('img_preg')) {
                    $filename = time() . "_" . $data["id"] . "_pregunta." . $data["img_preg"]->extension();

                    $mover = $request->img_preg->move(public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]), $filename);
                    if ($mover) {
                        $data["img_preg"] = $filename;
                        $data["ban_img"] = 1;
                    } else {
                        $data["img_preg"] = "";
                        $data["ban_img"] = 0;
                    }
                } else {
                    $data["img_preg"] = "";
                    $data["ban_img"] = 0;
                }
            } else {
                $data["img_preg"] = "";
                $data["ban_img"] = 0;
            }

            if ($data["ban_imgr1"] == "1") {
                if ($request->hasFile('imgr1')) {
                    $filename = time() . "_" . $data["id"] . "_pregunta_1." . $data["imgr1"]->extension();

                    $mover = $request->imgr1->move(public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]), $filename);
                    if ($mover) {
                        $data["imgr1"] = $filename;
                        $data["ban_imgr1"] = 1;
                    } else {
                        $data["imgr1"] = "";
                        $data["ban_imgr1"] = 0;
                    }
                } else {
                    $data["imgr1"] = "";
                    $data["ban_imgr1"] = 0;
                }
            } else {
                $data["imgr1"] = "";
                $data["ban_imgr1"] = 0;
            }

            if ($data["ban_imgr2"] == "1") {
                if ($request->hasFile('imgr2')) {
                    $filename = time() . "_" . $data["id"] . "_pregunta_2." . $data["imgr2"]->extension();

                    $mover = $request->imgr2->move(public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]), $filename);
                    if ($mover) {
                        $data["imgr2"] = $filename;
                        $data["ban_imgr2"] = 1;
                    } else {
                        $data["imgr2"] = "";
                        $data["ban_imgr2"] = 0;
                    }
                } else {
                    $data["imgr2"] = "";
                    $data["ban_imgr2"] = 0;
                }
            } else {
                $data["imgr2"] = "";
                $data["ban_imgr2"] = 0;
            }

            if ($data["ban_imgr3"] == "1") {
                if ($request->hasFile('imgr3')) {
                    $filename = time() . "_" . $data["id"] . "_pregunta_3." . $data["imgr3"]->extension();

                    $mover = $request->imgr3->move(public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]), $filename);
                    if ($mover) {
                        $data["imgr3"] = $filename;
                        $data["ban_imgr3"] = 1;
                    } else {
                        $data["imgr3"] = "";
                        $data["ban_imgr3"] = 0;
                    }
                } else {
                    $data["imgr3"] = "";
                    $data["ban_imgr3"] = 0;
                }
            } else {
                $data["imgr3"] = "";
                $data["ban_imgr3"] = 0;
            }

            if ($data["ban_imgr4"] == "1") {
                if ($request->hasFile('imgr4')) {
                    $filename = time() . "_" . $data["id"] . "_pregunta_4." . $data["imgr4"]->extension();

                    $mover = $request->imgr4->move(public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]), $filename);
                    if ($mover) {
                        $data["imgr4"] = $filename;
                        $data["ban_imgr4"] = 1;
                    } else {
                        $data["imgr4"] = "";
                        $data["ban_imgr4"] = 0;
                    }
                } else {
                    $data["imgr4"] = "";
                    $data["ban_imgr4"] = 0;
                }
            } else {
                $data["imgr4"] = "";
                $data["ban_imgr4"] = 0;
            }

            $datos = [
                "img_preg" => $data["img_preg"],
                "imgr1" => $data["imgr1"],
                "imgr2" => $data["imgr2"],
                "imgr3" => $data["imgr3"],
                "imgr4" => $data["imgr4"],
                "ban_img" => $data["ban_img"] ?? 0,
                "ban_imgr1" => $data["ban_imgr1"] ?? 0,
                "ban_imgr2" => $data["ban_imgr2"] ?? 0,
                "ban_imgr3" => $data["ban_imgr3"] ?? 0,
                "ban_imgr4" => $data["ban_imgr4"] ?? 0
            ];

            $respuesta = $this->materiaService->modifyPreguntaImagenes($datos, $data["id"]);
            $pregunta = $this->materiaService->getPreguntaById($data["id"]);
            return response()->json([
                'ok' => true,
                'pregunta' => $pregunta
            ], 201);
            // if ($respuesta) {
            // } else {
            //     return response()->json([
            //         'ok' => false,
            //         'error' => "Las imagenes no fueron subidas"
            //     ], 500);
            // }
        } else {
            return response()->json([
                'ok' => false,
                'error' => "La pregunta no fue creada"
            ], 500);
        }
    }

    public function modify(PreguntaRequest $request)
    {

        $id = request()->get('id');

        if (auth()->user()->role_id != 1) {
            return response()->json([
                'ok' => false,
                'errors' => "El usuario no tiene permisos para realizar esta operación"
            ], 500);
        }

        $data = $request->validated();
        $data["id"] = $id;

        if ($data["ban_img"] == "1") {
            if ($request->hasFile('img_preg')) {
                $filename = time() . "_" . $data["id"] . "_pregunta." . $data["img_preg"]->extension();

                $mover = $request->img_preg->move(public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]), $filename);
                if ($mover) {
                    $data["img_preg"] = $filename;
                    $data["ban_img"] = 1;
                } else {
                    $data["img_preg"] = "";
                    $data["ban_img"] = 0;
                }
            } else {
                $verificar = $this->verificar($data['img_preg']);
                if (!$verificar) {
                    $data["img_preg"] = "";
                    $data["ban_img"] = 0;
                }
            }
        } else {
            $carpeta = public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]);
            $archivo = $carpeta . "/" . $data['img_preg'];
            if (is_file($archivo)) {
                unlink($archivo);
            }
            $data["img_preg"] = "";
            $data["ban_img"] = 0;
        }

        if ($data["ban_imgr1"] == "1") {
            if ($request->hasFile('imgr1')) {
                $filename = time() . "_" . $data["id"] . "_pregunta_1." . $data["imgr1"]->extension();

                $mover = $request->imgr1->move(public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]), $filename);
                if ($mover) {
                    $data["imgr1"] = $filename;
                    $data["ban_imgr1"] = 1;
                } else {
                    $data["imgr1"] = "";
                    $data["ban_imgr1"] = 0;
                }
            } else {
                $verificar = $this->verificar($data['imgr1']);
                if (!$verificar) {
                    $data["imgr1"] = "";
                    $data["ban_imgr1"] = 0;
                }
            }
        } else {
            $carpeta = public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]);
            $archivo = $carpeta . "/" . $data['imgr1'];
            if (is_file($archivo)) {
                unlink($archivo);
            }
            $data["imgr1"] = "";
            $data["ban_imgr1"] = 0;
        }

        if ($data["ban_imgr2"] == "1") {
            if ($request->hasFile('imgr2')) {
                $filename = time() . "_" . $data["id"] . "_pregunta_2." . $data["imgr2"]->extension();

                $mover = $request->imgr2->move(public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]), $filename);
                if ($mover) {
                    $data["imgr2"] = $filename;
                    $data["ban_imgr2"] = 1;
                } else {
                    $data["imgr2"] = "";
                    $data["ban_imgr2"] = 0;
                }
            } else {
                $verificar = $this->verificar($data['imgr2']);
                if (!$verificar) {
                    $data["imgr2"] = "";
                    $data["ban_imgr2"] = 0;
                }
            }
        } else {
            $carpeta = public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]);
            $archivo = $carpeta . "/" . $data['imgr2'];
            if (is_file($archivo)) {
                unlink($archivo);
            }
            $data["imgr2"] = "";
            $data["ban_imgr2"] = 0;
        }

        if ($data["ban_imgr3"] == "1") {
            if ($request->hasFile('imgr3')) {
                $filename = time() . "_" . $data["id"] . "_pregunta_3." . $data["imgr3"]->extension();

                $mover = $request->imgr3->move(public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]), $filename);
                if ($mover) {
                    $data["imgr3"] = $filename;
                    $data["ban_imgr3"] = 1;
                } else {
                    $data["imgr3"] = "";
                    $data["ban_imgr3"] = 0;
                }
            } else {
                $verificar = $this->verificar($data['imgr3']);
                if (!$verificar) {
                    $data["imgr3"] = "";
                    $data["ban_imgr3"] = 0;
                }
            }
        } else {
            $carpeta = public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]);
            $archivo = $carpeta . "/" . $data['imgr3'];
            if (is_file($archivo)) {
                unlink($archivo);
            }
            $data["imgr3"] = "";
            $data["ban_imgr3"] = 0;
        }

        if ($data["ban_imgr4"] == "1") {
            if ($request->hasFile('imgr4')) {
                $filename = time() . "_" . $data["id"] . "_pregunta_4." . $data["imgr4"]->extension();

                $mover = $request->imgr4->move(public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]), $filename);
                if ($mover) {
                    $data["imgr4"] = $filename;
                    $data["ban_imgr4"] = 1;
                } else {
                    $data["imgr4"] = "";
                    $data["ban_imgr4"] = 0;
                }
            } else {
                $verificar = $this->verificar($data['imgr4']);
                if (!$verificar) {
                    $data["imgr4"] = "";
                    $data["ban_imgr4"] = 0;
                }
            }
        } else {
            $carpeta = public_path('imagenes/preguntas/' . $data["test_id"] . '/' . $data["id"]);
            $archivo = $carpeta . "/" . $data['imgr4'];
            if (is_file($archivo)) {
                unlink($archivo);
            }
            $data["imgr4"] = "";
            $data["ban_imgr4"] = 0;
        }

        if ($data["competencia"] == null || $data["competencia"] == '' || $data["competencia"] == 'null') {
            $data["competencia"] = '';
        }
        if ($data["que_desc2"] == null || $data["que_desc2"] == '' || $data["que_desc2"] == 'null') {
            $data["que_desc2"] = '';
        }
        if ($data["que_desc3"] == null || $data["que_desc3"] == '' || $data["que_desc3"] == 'null') {
            $data["que_desc3"] = '';
        }

        $pregunta = $this->materiaService->modifyPregunta($data, $id);
        if ($pregunta) {
            $pregunta = $this->materiaService->getPreguntaById($id);
            return response()->json([
                'ok' => true,
                'pregunta' => $pregunta
            ], 201);
        } else {
            return response()->json([
                'ok' => false,
                'error' => "La institución no fue modificada"
            ], 500);
        }
    }

    private function verificar($cadena)
    {
        $array = array(".jpg", ".jpeg", ".png", ".JPG", ".JPEG", ".PNG");

        foreach ($array as $elemento) {
            if (str_ends_with($cadena, $elemento)) {
                return true;
                break;
            }
        }

        return false;
    }

    private function convertir($pregunta)
    {
        $objecto = [];
        if ($pregunta) {
            $objecto = [
                "id" => $pregunta->id,
                "test_id" => $pregunta->test_id,
                'que_desc' => $pregunta->que_desc,
                'ans1' => $pregunta->ans1,
                'ans2' => $pregunta->ans2,
                "ans3" => $pregunta->ans3,
                "ans4" => $pregunta->ans4,
                "true_ans" => $pregunta->true_ans,
                "img_preg" => mb_convert_encoding($pregunta->img_preg, 'UTF-8', 'ISO-8859-1'),
                "imgr1" => mb_convert_encoding($pregunta->imgr1, 'UTF-8', 'ISO-8859-1'),
                "imgr2" => mb_convert_encoding($pregunta->imgr2, 'UTF-8', 'ISO-8859-1'),
                "imgr3" => mb_convert_encoding($pregunta->imgr3, 'UTF-8', 'ISO-8859-1'),
                "imgr4" => mb_convert_encoding($pregunta->imgr4, 'UTF-8', 'ISO-8859-1'),
                "ban_img" => $pregunta->ban_img,
                "ban_imgr1" => $pregunta->ban_imgr1,
                "ban_imgr2" => $pregunta->ban_imgr2,
                "ban_imgr3" => $pregunta->ban_imgr3,
                "ban_imgr4" => $pregunta->ban_imgr4,
                "sesion" => $pregunta->sesion,
                "simulacro" => $pregunta->simulacro,
                "componente" => $pregunta->componente,
                "competencia" => $pregunta->competencia,
                "que_desc2" => $pregunta->que_desc2,
                "que_desc3" => $pregunta->que_desc3,
                "pre_test" => $pregunta->pre_test,
                "estado" => $pregunta->estado
            ];
        }
        return $objecto;
    }
}
