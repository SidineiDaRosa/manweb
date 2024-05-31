<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaProduto extends Model
{
    use HasFactory;
    protected $table='entradas_produtos';
    protected $fillable=[
        'produto_id',
        'fornecedor_id',
        'quantidade',
        'valor',
        'nota_fiscal',
        'data',
        'empresa_id'
    ];

    public function produto(){
        return $this->belongsTo('App\Models\Produto');
    }
    public function Fornecedor(){
        return $this->belongsTo('App\Models\Fornecedor');
    }
    public function Empresa(){
        return $this->belongsTo('App\Models\Empresas');
    }
}
