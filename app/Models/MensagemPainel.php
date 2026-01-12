<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensagemPainel extends Model
{
    protected $table = 'mensagens_painel';

    protected $fillable = [
        'titulo',
        'mensagem',
        'tipo',
        'ativo',
        'inicio',
        'fim',
        'ordem',
    ];

    protected $casts = [
        'ativo'  => 'boolean',
        'inicio' => 'datetime',
        'fim'    => 'datetime',
    ];
}
