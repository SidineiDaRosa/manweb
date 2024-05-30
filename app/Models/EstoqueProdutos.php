<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstoqueProdutos extends Model
{
    use HasFactory;
    protected $table = 'estoque_produtos';
    protected $fillable = [
        'empresa_id',
        'produto_id',
        'unidade_medida',
        'quantidade',
        'valor',
        'estoque_minimo',
        'estoque_maximo',
        'local',

    ];

    public function produto()
    {
        return $this->belongsTo('App\Models\Produto');
    }
    public function Empresa()
    {
        return $this->belongsTo('App\Models\Empresas');
    }
    public function unidade_medida()
    {
        //  return $this->belongsTo('App\Models\UnidadeMedida', 'unidade_medida_id', 'id');
        return $this->belongsTo('App\Models\UnidadeMedida');
    }
}
