<?php

namespace App\Models;

use App\Http\Controllers\PedidoSaidaListaController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoSaida extends Model
{
    use HasFactory;
    protected $table='pedidos_saida';
    protected $fillable=[
        'data_emissao',
        'hora_emissao',
        'data_prevista',
        'hora_prevista',
        'empresa_id',
        'equipamento_id',
        'funcionarios_id',
        'fornecedor_id',
        'status',
        'descricao',
        'ordem_servico_id'
        

    ];
    public function Empresa(){
        return $this->belongsTo('App\Models\Empresas');
    }
    public function Equipamento()
    {
        return $this->belongsTo('App\Models\Equipamento');
    }
    public function funcionarios()
    {
        return $this->belongsTo('App\Models\Funcionario');
    }
  
    public function produto(){
        return $this->belongsTo('App\Models\Produto');
    }
    public function ordens_servicos(){
        return $this->belongsTo('App\Models\OrdemServico');
    }
}
