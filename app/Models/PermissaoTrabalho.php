<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissaoTrabalho extends Model
{
    use HasFactory;

    // Nome da tabela (se não seguir a convenção Laravel)
    protected $table = 'permissao_trabalho';

    // Campos que podem ser preenchidos via mass assignment
    protected $fillable = [
        'apr_id',
        'tipo_trabalho',
        'inicio_trabalho',
        'fim_trabalho',
        'local_trabalho',
        'responsavel',
        'descricao_atividade',
        'observacoes'
    ];

    // Relacionamento com APR
    public function apr()
    {
        return $this->belongsTo(Apr::class);
    }
}
