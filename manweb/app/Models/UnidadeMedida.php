<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadeMedida extends Model
{
    use HasFactory;
    protected $fillable=['nome', 'descricao'];
    protected $table='unidades_medida';
    
    public function unidade_medida(){
        //  return $this->belongsTo('App\Models\UnidadeMedida', 'unidade_medida_id', 'id');
        return $this->belongsTo('App\Models\Produto');
        
      }
      public function unidade_de_medida(){
        return $this->belongsTo('App\Models\PedidoCompraLista');
        
      }
}

