<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoCompraLista extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table='pedido_compra_lista';
    protected $fillable=[
        'pedidos_compra_id',
        'produto_id',
        'quantidade', 

    ];
    public function pedidoCompra()
    {
        return $this->belongsTo(PedidoCompra::class, 'pedidos_compra_id');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
