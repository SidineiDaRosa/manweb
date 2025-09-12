<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoCompraEvento extends Model
{
    // Nome da tabela
    protected $table = 'pedido_compra_eventos';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'pedido_compra_id',
        'status_anterior',
        'status_novo',
        'usuario_id',
        'justificativa',
        'anexo'
    ];

    /**
     * Relacionamento com PedidoCompra
     */
    public function pedidoCompra(): BelongsTo
    {
        return $this->belongsTo(PedidoCompra::class, 'pedido_compra_id');
    }

    /**
     * Relacionamento com Usuário (quem fez a alteração)
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
