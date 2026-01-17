<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRisco extends Model
{
    use HasFactory;

    protected $table = 'material_risco'; // tabela pivô

    protected $fillable = [
        'risco_id',      // atualizei para risco_id
        'material_id',
        'status',
        'observacoes',
    ];

    // Relacionamento com MaterialEpi
    public function material()
    {
        return $this->belongsTo(MaterialEpi::class, 'material_id');
    }

    // Relacionamento com Risco (nova tabela)
    public function risco()
    {
        return $this->belongsTo(Risco::class, 'risco_id'); // aponta para a tabela correta
    }
}
