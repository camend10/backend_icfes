<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntajeMaximoMinimo extends Model
{
    use HasFactory;

    protected $table = 'puntajes_maximos_minimos';

    protected $fillable = [
        "simulacro_id",
        "materia_id",
        "materia",
        "grado_id",
        "curso_id",
        "puntaje_maximo",
        "puntaje_minimo",
        "puntaje_promedio"
    ];
}
