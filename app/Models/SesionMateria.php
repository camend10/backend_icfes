<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionMateria extends Model
{
    use HasFactory;

    protected $table = 'sesiones_materias';

    protected $fillable = [
        "estado",
        'materia_id',
        'sesion_id',
        'num_pregunta'
    ];

    public function materias()
    {
        return $this->belongsTo(Materia::class, 'materia_id')->withDefault();
    }

    public function sesiones()
    {
        return $this->belongsTo(Sesion::class, 'sesion_id')->withDefault();
    }
}
