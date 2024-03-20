<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    protected $table = 'mst_question';

    protected $fillable = [
        "test_id",
        'que_desc',
        'ans1',
        'ans2',
        "ans3",
        "ans4",
        "true_ans",
        "img_preg",
        "imgr1",
        "imgr2",
        "imgr3",
        "imgr4",
        "ban_img",
        "ban_imgr1",
        "ban_imgr2",
        "ban_imgr3",
        "ban_imgr4",
        "sesion",
        "simulacro",
        "componente",
        "competencia",
        "que_desc2",
        "que_desc3",
        "pre_test",
        "estado",
        "user_id"
    ];
}
