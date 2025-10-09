<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LubrificacaoIntervalo extends Model
{
    use HasFactory;

    protected $table = 'lubrificacao_intervalos';

    protected $fillable = [
        'lubrificacao_id',
        'valor',
        'unidade', // id da unidade de medida
    ];

    // Relacionamento com Lubrificacao
    public function lubrificacao()
    {
        return $this->belongsTo(Lubrificacao::class, 'lubrificacao_id', 'id');
    }

    // Relacionamento com UnidadeMedida
    public function unidadeMedida()
    {
        return $this->belongsTo(UnidadeMedida::class, 'unidade', 'id');
    }
}
