<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntajeGlobalInstitucion extends Model
{
    use HasFactory;

    protected $table = 'puntaje_global_institucion';

    protected $fillable = [
        "fecha",
        "simulacro_id",
        "user_id",
        "suma_pesos",
        "peso_todo",
        "peso_total",
        "grado_id",
        "curso_id",
        "promedio",
        "contador"
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
