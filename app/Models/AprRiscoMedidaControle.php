<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AprRiscoMedidaControle extends Model
{
    use HasFactory;

    protected $table = 'apr_risco_medidas';

    protected $fillable = [
        'apr_risco_id',
        'descricao',
    ];

    /**
     * Cada medida pertence a um registro de risco da APR
     */
    public function aprRisco()
    {
        return $this->belongsTo(AprRisco::class);
    }
}
