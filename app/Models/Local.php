<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $table = 'area_local'; // ajuste se sua tabela tiver outro nome

    protected $fillable = [
        'nome',
        'descricao',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONAMENTOS
    |--------------------------------------------------------------------------
    */

    // APRs vinculadas a este local
    public function aprs()
    {
        return $this->hasMany(Apr::class, 'local_id');
    }

    // Ordens de Serviço vinculadas a este local
    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class, 'local_id');
    }

    // Equipamentos vinculados a este local (se existir)
    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class, 'local_id');
    }
}
