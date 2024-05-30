<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaidaProduto extends Model
{
    use HasFactory;
    protected $table='saidas_produtos';
    protected $fillable=[
        'pedidos_saida_id',
        'produto_id',
        'unidade_medida',
        'quantidade',
        'valor',
        'subtotal',
        'data',
        'equipamento_id'
    ];

    public function produto(){
        return $this->belongsTo('App\Models\Produto');
    }
    public function Equipamento()
    {
        return $this->belongsTo('App\Models\Equipamento');
    }
    public function unidade_medida(){
        //  return $this->belongsTo('App\Models\UnidadeMedida', 'unidade_medida_id', 'id');
        return $this->belongsTo('App\Models\UnidadeMedida');
      }
     
  
}
