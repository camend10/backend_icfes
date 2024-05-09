<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puntaje extends Model
{
    use HasFactory;

    protected $table = 'puntajes';

    protected $fillable = [
        "estado",
        "fecha",
        "user_id",
        "materia_id",
        "materia",
        "peso",
        "simulacro_id",
        "sesion_id",
        "puntaje",
        "identificacion",
        "name",
        "email",
        "telefono",
        "direccion",
        "codigo",
        "grado",
        "sigla",
        "grado_id",
        "curso_id"
    ];
}
