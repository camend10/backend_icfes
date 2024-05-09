<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoCompetencias extends Model
{
    use HasFactory;

    protected $table = 'resultado_competencias';

    protected $fillable = [
        "true_ans",
        "compe_id",
        "competencia",
        "respuesta",
        "user_id",
        "materia_id",
        "simulacro_id",
        "sesion_id",
        "total",
        "percent"
    ];
}
