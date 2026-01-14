<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AprRisco extends Model
{
    use HasFactory;

    protected $table = 'apr_riscos';

    protected $fillable = [
        'apr_id',
        'risco_id',
        'probabilidade',
        'severidade',
        'grau',
        'medidas_controle',
        'status'
    ];

    /**
     * Cada análise pertence a uma APR
     */
    public function apr()
    {
        return $this->belongsTo(Apr::class);
    }

    /**
     * Cada análise está vinculada a um risco cadastrado
     */
    public function risco()
    {
        return $this->belongsTo(Risco::class, 'risco_id');
    }
}
