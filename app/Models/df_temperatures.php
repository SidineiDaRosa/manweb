<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class df_temperatures extends Model
{
    use HasFactory;

    // 1. Define explicitamente o nome da tabela no banco
    protected $table = 'df_temperatures';

    // 2. Desativa os timestamps padrão do Laravel (created_at e updated_at)
    public $timestamps = false;

    // 3. Define quais colunas podem ser preenchidas em massa (Mass Assignment)
    protected $fillable = [
        'equipamento',
        'temperatura'
    ];
}
