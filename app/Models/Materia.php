<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'materias';

    protected $fillable = [
        "sub_id",
        'test_name',
        'total_que',
        'estado',
        "imagen"
    ];
}
