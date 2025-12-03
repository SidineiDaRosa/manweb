<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;
    protected $table = 'funcionarios';
    protected $fillable = [
        'id',
        'primeiro_nome',
        'ultimo_nome',
        'cpf',
        'rg',
        'endereco',
        'num_casa',
        'bairro',
        'cidade',
        'uf',
        'funcao',
        'user',
        'status'
    ];
    // Um funcionário pode ter muitos serviços executados
    public function servicosExecutados()
    {
        return $this->hasMany(Servicos_Executado::class, 'funcionario_id');
    }
    public function funcionario()
    {
        return $this->hasMany(Servicos_Executado::class, 'funcionario_id');
    }
}
