<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamePacote extends Model
{
    protected $table = 'exame_pacote';

    protected $fillable = [
        'idExame',
        'idPacote',
    ];
}
