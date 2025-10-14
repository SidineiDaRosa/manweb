<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    // Tabela correspondente
    protected $table = 'projetos';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'descricao',
        'data_inicio',
        'data_fim',
        'status',
        'responsavel_id',
    ];

    // Relacionamento com o responsável (Funcionario)
    public function responsavel()
    {
        return $this->belongsTo(Funcionario::class, 'responsavel_id');
    }
}
