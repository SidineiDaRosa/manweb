<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apr extends Model
{
    use HasFactory;

    protected $table = 'aprs';

    /**
     * Campos permitidos para preenchimento em massa.
     */
    protected $fillable = [
        'ordem_servico_id',
        'local_trabalho',
        'descricao_atividade',
        'riscos_identificados',
        'medidas_controle',
        'epi_obrigatorio',
        'responsavel',
        'assinatura_responsavel',
        'status',
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
    // No modelo Apr
    public function user()
    {
        return $this->belongsTo(User::class, 'responsavel'); // assumindo que 'responsavel' guarda o ID do usuário mostra o nome em show apr
    }
}
