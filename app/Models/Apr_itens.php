<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APRItem extends Model
{
    use HasFactory;

    protected $table = 'apr_itens';

    protected $fillable = [
        'apr_id',
        'atividade',
        'risco',
        'medida_controle',
        'epi',
    ];

    /**
     * Relacionamento: um item pertence a uma APR
     */
    public function apr()
    {
        return $this->belongsTo(APR::class, 'apr_id');
    }
}
