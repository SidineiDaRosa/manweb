<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitacaoOs extends Model
{
    use HasFactory;
    protected $table = 'solicitacao_os';
    protected $fillable = [
        'datatime',
        'emissor',
        'descricao',
        'status'
    ];

    public function funcionario()
    {
        return $this->belongsTo('App\Models\Funcionario');
    }
}