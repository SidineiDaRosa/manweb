<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risco extends Model
{
    use HasFactory;

    protected $table = 'riscos';

    protected $fillable = [
        'tipo_risco',
        'nome',
        'descricao',
        'ativo',
        'link_item'
    ];

    /**
     * Um risco pode aparecer em várias análises de APR
     */
    public function analises()
    {
        return $this->hasMany(AprRisco::class, 'risco_id');
    }
    public function medidasControle()
    {
        return $this->hasMany(RiscoMedidaControle::class, 'risco_id');
    }
    // Relacionamento com o pivô material_risco
    public function materiaisRiscos()
    {
        return $this->hasMany(MaterialRisco::class, 'material_id');
    }

    // Relacionamento direto com Riscos via pivô
    public function riscos()
    {
        return $this->belongsToMany(
            Risco::class,       // Modelo final
            'material_risco',   // Tabela pivô
            'material_id',      // FK no pivô para Material
            'risco_id'          // FK no pivô para Risco
        )->withPivot('status', 'observacoes', 'created_at', 'updated_at');
    }
    public function medidas()
    {
        return $this->hasMany(RiscoMedidaControle::class, 'risco_id');
    }
    public function materiais()
    {
        return $this->hasMany(MaterialRisco::class, 'risco_id');
    }
}
