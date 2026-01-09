<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'tipo',        // 'F' ou 'J'
        'nome1',       // Nome principal / Razão Social
        'nome2',       // Nome complementar / Nome Fantasia
        'nome3',       // Complemento opcional
        'nome4',       // Complemento opcional
        'cnpj',        // CPF ou CNPJ
        'insc_estadual',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'telefone',
        'contato',
        'email',
        'site',
        'segmento',
        'funcao',
    ];

    // Evita alteração de campos que não devem ser preenchidos via mass assignment
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Opcional: Accessor para exibir o "nome completo" de acordo com o tipo
    public function getNomeCompletoAttribute()
    {
        return $this->name1; // Para PF ou PJ, name1 é sempre o principal
    }
}
