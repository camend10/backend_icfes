<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntajeGlobalMateriasInstitucion extends Model
{
    use HasFactory;

    protected $table = 'puntajes_global_materias_institucion';

    protected $fillable = [
        "simulacro_id",
        "user_id",
        "grado_id",
        "curso_id",
        "materia_id",
        "materia",
        "peso",
        "fecha",
        "puntaje_total",
        "distinto",
        "promedio_total",
        "gran_prom_total"
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
