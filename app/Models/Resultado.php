<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    protected $table = 'resultados';

    protected $fillable = [
        "user_id",
        "materia_id",
        "simulacro_id",
        "sesion_id",
        "puntaje",
        "estado"
    ];
}
