<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pacote extends Model
{
    protected $fillable = [
        'name',
        'observations',
    ];

    public function exames(): BelongsToMany
    {
        return $this->belongsToMany(Exame::class, 'exame_pacote', 'idPacote', 'idExame');
    }
}
