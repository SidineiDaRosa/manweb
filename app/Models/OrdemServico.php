<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServico extends Model
{
    use HasFactory;
    protected $table = 'ordens_servicos';
    protected $fillable = [
        'id',
        'data_emissao',
        'hora_emissao',
        'data_inicio',
        'hora_inicio',
        'data_fim',
        'hora_fim',
        'equipamento_id',
        'emissor',
        'responsavel',
        'descricao',
        'status_servicos',
        'link_foto',
        'gravidade',
        'urgencia',
        'tendencia',
        'empresa_id',
        'situacao',
        'natureza_do_servico',
        'especialidade_do_servico',
        'ss_id',
        'anexo',
        'projeto_id',
        'check',
        'alarm'
    ];
    public function equipamento()
    {
        return $this->belongsTo('App\Models\Equipamento');
    }

    public function Empresa()
    {
        return $this->belongsTo('App\Models\Empresas');
    }
    public function Projeto()
    {
        return $this->belongsTo('App\Models\Projeto', 'projeto_id');
    }
    public function ss()
    {
        return $this->belongsTo(SolicitacaoOs::class, 'ss_id'); // ss_id é a FK na ordem_servicos
    }
    public function apr()
    {
        return $this->hasOne(APR::class, 'ordem_servico_id');
    }
}
