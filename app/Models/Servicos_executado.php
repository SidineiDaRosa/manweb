<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicos_executado extends Model
{
    use HasFactory;
    protected $table = 'servicos_executados';
    protected $fillable = [
        'ordem_servico_id',
        'data_inicio',
        'hora_inicio',
        'data_fim',
        'hora_fim',
        'funcionario_id',
        'descricao',
        'subtotal'

    ];

    public function funcionario()
    {
        return $this->belongsTo('App\Models\Funcionario');
    }
}
