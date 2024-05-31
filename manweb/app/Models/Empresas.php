<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;
    protected $table = 'empresas';
    protected $fillable = [
        'id',
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'insc_estadual',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'funcao',
        'telefone',
        'contato',
        'email',
        'site',
        'segmento',

    ];
}
