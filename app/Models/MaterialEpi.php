<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialEpi extends Model
{
    use HasFactory;

    protected $table = 'materiais';

    protected $fillable = [
        'nome',
        'tipo',
        'descricao',
        'codigo',
        'ca',
        'validade',
        'prazo_inspecao',
        'marca',
        'local_armazenamento',
        'quantidade_estoque',
        'status',
        'observacoes'
    ];

    // Relacionamento com MaterialRisco (pivô)
    public function materiaisRiscos()
    {
        return $this->hasMany(MaterialRisco::class, 'material_id');
    }

    // Relação direta com Riscos via pivô
    public function riscos()
    {
        return $this->hasManyThrough(
            Risco::class,        // modelo final (Risco)
            MaterialRisco::class, // pivô
            'material_id',       // FK no pivô apontando para este material
            'id',                // PK do Risco
            'id',                // PK do material
            'risco_id'           // FK no pivô apontando para o Risco
        );
    }
}
