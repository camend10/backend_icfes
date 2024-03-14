<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;

    protected $table = 'instituciones';

    protected $fillable = [
        "estado",
        'codigo',
        'nit',
        'nombre',
        "direccion",
        "telefono",
        'email',
        "departamento_id",
        "municipio_id",
        "user_id",
        "foto"
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}
