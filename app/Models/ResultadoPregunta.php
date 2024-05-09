<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoPregunta extends Model
{
    use HasFactory;

    protected $table = 'resultados_preguntas';

    protected $fillable = [
        "user_id",
        "materia_id",
        "simulacro_id",
        "sesion_id",
        "pregunta_id",
        "estado",
        "respuesta"
    ];
}
