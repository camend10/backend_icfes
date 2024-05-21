<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoCompetenciasGlobal extends Model
{
    use HasFactory;

    protected $table = 'resultado_competencias_global';

    protected $fillable = [
        "true_ans",
        "compo_id",
        "competencia",
        "respuesta",
        "user_id",
        "materia_id",
        "simulacro_id",
        "sesion_id",
        "total",
        "percent",
        "grado_id",
        "curso_id",
        "porcentaje",
    ];

    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id')->withDefault();
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id')->withDefault();
    }
}
