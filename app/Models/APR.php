<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Funcionario;

class Apr extends Model
{
    use HasFactory;

    protected $table = 'aprs';

    /**
     * Campos permitidos para preenchimento em massa.
     */
    protected $fillable = [
        'ordem_servico_id',
        'localizacao_id',
        'descricao_atividade',
        'responsavel_id',
        'assinatura_responsavel',
        'status',
        'prazo'
    ];

    /**
     * Relação: A APR pertence a uma Ordem de Serviço.
     */
    public function ordemServico()
    {
        return $this->belongsTo(OrdemServico::class, 'ordem_servico_id');
    }

    /**
     * Verifica se está finalizada.
     */
    public function isFinalizada()
    {
        return $this->status === 'finalizada';
    }

    public function responsavel()
    {
        return $this->belongsTo(Funcionario::class, 'responsavel_id');
    }
    public function localizacao()
    {
        return $this->belongsTo(AreaLocal::class, 'localizacao_id');
    }
}
