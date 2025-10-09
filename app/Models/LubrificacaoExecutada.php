<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LubrificacaoExecutada extends Model
{
    use HasFactory;

    protected $table = 'lubrificacoes_executadas'; // opcional, mas explícito

    protected $fillable = [
        'lubrificacao_id',
        'executante',       // corrigido do 'responsavel
        'observacoes',
    ];

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }

    public function lubrificacao()
    {
        return $this->belongsTo(Lubrificacao::class);
    }
}
