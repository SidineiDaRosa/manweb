<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lubrificacao extends Model
{
    use HasFactory;

    protected $table = 'lubrificacao';

    protected $fillable = [
        'equipamento_id',
        'produto_id',
        'observacoes',
        'tag',
        'intervalo'
    ];

    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $casts = [
        'criado_em' => 'datetime',
        'atualizado_em' => 'datetime',
    ];

    // Relacionamento com Equipamento
    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class, 'equipamento_id');
    }

    // Relacionamento com Produto
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    // Relacionamento com UnidadeMedida
    public function unidadeMedida()
    {
        return $this->belongsTo(UnidadeMedida::class, 'unidade', 'id');
    }

    // ⚡ Relacionamento com intervalos
    public function intervalos()
    {
        return $this->hasMany(LubrificacaoIntervalo::class, 'lubrificacao_id', 'id');
    }
}
