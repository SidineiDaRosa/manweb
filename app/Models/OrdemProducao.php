<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemProducao extends Model
{
    use HasFactory;
    protected $table = 'ordens_producoes';
    protected $fillable = [
        'equipamento_id',
        'produto_id',
        'quantidade_producao',
        'data_inicio',
        'data_fim',
        'hora_inicio',
        'hora_fim',
        'horimetro_final',
        'status'
    ];

    public function equipamento()
    {
        return $this->belongsTo('App\Models\Equipamento');
    }

    public function produto()
    {
        return $this->belongsTo('App\Models\Produto');
    }
}
