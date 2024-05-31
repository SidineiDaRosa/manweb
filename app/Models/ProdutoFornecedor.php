<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoFornecedor extends Model
{
    use HasFactory;
    protected $table='produtos_fornecedores';

    public function produto(){
        return $this->belongsTo('App\Models\Produto');
    }

    public function fornecedor(){
        return $this->belongsTo('App\Models\Fornecedor');
    }
}
