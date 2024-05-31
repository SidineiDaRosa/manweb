<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoCompra extends Model
{
    use HasFactory;
    protected $table='pedidos_compra';
    protected $fillable=[
        'data_emissao',
        'hora_emissao',
        'data_prevista',
        'hora_prevista',
        'equipamento_id',
        'funcionarios_id',
        'status',
        'descricao'
    ];
    public function Equipamento()
    {
        return $this->belongsTo('App\Models\Equipamento');
    }
    public function funcionarios()
    {
        return $this->belongsTo('App\Models\Funcionario');
    }
}
