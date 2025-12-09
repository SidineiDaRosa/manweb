<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'familia_id',
        'cod_fabricante',
        'nome',
        'descricao',
        'marca_id',
        'unidade_medida_id',
        'categoria_id',
        'link_peca',
        'image',
        'image2',
        'image3',
        'status'
    ];

    public function marca()
    {
        return $this->belongsTo('App\Models\Marca');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria');
    }

    public function unidade_medida()
    {
        return $this->belongsTo('App\Models\UnidadeMedida');
    }

    public function familia()
    {
        return $this->belongsTo(Familia::class);
    }
      public function produto()
    {
        return $this->belongsTo('App\Models\Produto');
    }
}
