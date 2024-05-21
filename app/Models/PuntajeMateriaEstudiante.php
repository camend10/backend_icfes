<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntajeMateriaEstudiante extends Model
{
    use HasFactory;

    protected $table = 'puntajes_materia_estudiante';

    protected $fillable = [
        "simulacro_id",
        "materia_id",
        "materia",
        "peso",
        "user_id",
        "puntaje_total"
    ];
}
