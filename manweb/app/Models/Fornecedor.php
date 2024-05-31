<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    //

    protected $table = 'fornecedores';
    protected $fillable = ['razao_social',
     'nome_fantasia',
      'cnpj',
       'insc_estadual',
       'endereco',
       'bairro',
       'cidade',
       'estado',
       'telefone',
       'contato',
       'email',
       'site'
    ];
}
