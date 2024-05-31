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
        'situacao'
    ];
    public function equipamento()
    {
        return $this->belongsTo('App\Models\Equipamento');
    }
    public function funcionario()
    {
        return $this->belongsTo('App\Models\Funcionario');
    }
    public function Empresa(){
        return $this->belongsTo('App\Models\Empresas');
    }
}
