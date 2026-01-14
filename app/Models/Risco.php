<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risco extends Model
{
    use HasFactory;

    protected $table = 'riscos';

    protected $fillable = [
        'tipo_risco',
        'nome',
        'descricao',
        'ativo',
    ];

    /**
     * Um risco pode aparecer em várias análises de APR
     */
    public function analises()
    {
        return $this->hasMany(AprRisco::class, 'risco_id');
    }
}
