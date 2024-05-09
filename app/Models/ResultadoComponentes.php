<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoComponentes extends Model
{
    use HasFactory;

    protected $table = 'resultado_componentes';

    protected $fillable = [
        "true_ans",
        "compo_id",
        "componente",
        "respuesta",
        "user_id",
        "materia_id",
        "simulacro_id",
        "sesion_id",
        "total",
        "percent"
    ];
}
