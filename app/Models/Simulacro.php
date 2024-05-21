<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulacro extends Model
{
    use HasFactory;


    protected $table = 'simulacros';

    protected $fillable = [
        "nombre",
        "estado",
        "imagen",
        "resultados",
    ];
}
