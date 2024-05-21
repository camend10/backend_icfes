<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntajeTotalMaximoMinimo extends Model
{
    use HasFactory;

    protected $table = 'puntaje_total_max_min';

    protected $fillable = [
        "simulacro_id",
        "materia_id",
        "grado_id",
        "curso_id",
        "user_id",
        "materia",
        "puntaje_estudiante",
        "puntaje_maximo",
        "puntaje_minimo",
        "puntaje_promedio"
    ];
}
