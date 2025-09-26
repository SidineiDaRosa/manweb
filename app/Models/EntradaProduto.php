<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaProduto extends Model
{
    use HasFactory;
    protected $table = 'entradas_produtos';
    protected $fillable = [
        'produto_id',
        'quantidade',
        'fornecedor_id',
        'empresa_id',
        'valor',
        'data',
        'nota_fiscal',
        'pedido_compra_id',
    ];
    public function produto()
    {
        return $this->belongsTo('App\Models\Produto');
    }
    public function Fornecedor()
    {
        return $this->belongsTo('App\Models\Fornecedor');
    }
    public function Empresa()
    {
        return $this->belongsTo('App\Models\Empresas');
    }
}
