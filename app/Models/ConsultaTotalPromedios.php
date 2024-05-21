<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultaTotalPromedios extends Model
{
    use HasFactory;

    protected $table = 'consulta_total_promedios';

    protected $fillable = [
        "simulacro_id",
        "user_id",
        "materia_id",
        "grado_id",
        "curso_id",
        "materia",
        "puntaje_maximo",
        "puntaje_minimo",
        "puntaje_promedio"
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
