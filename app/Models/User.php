<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $fillable = [
        'tipo_doc_id',
        'identificacion',
        'name',
        'email',
        "username",
        'password',
        "telefono",
        "direccion",
        "grado_id",
        "curso_id",
        "estado",
        "departamento_id",
        "municipio_id",
        "role_id",
        "tipo",
        "codigo",
        "jornada",
        "fecha_nacimiento",
        "user_id",
        "foto",
        "genero",
        "institucion_id"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class)->withDefault();
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class)->withDefault();
    }

    public function tipodocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_doc_id')->withDefault();
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class)->withDefault();
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class)->withDefault();
    }

    public function rol()
    {
        return $this->belongsTo(Role::class, 'role_id')->withDefault();
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id')->withDefault();
    }
}
