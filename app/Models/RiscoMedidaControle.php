<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiscoMedidaControle extends Model
{
    use HasFactory;

    protected $table = 'risco_medidas';

    protected $fillable = [
        'risco_id',
        'descricao',
    ];


    /**
     * Cada medida pertence a um registro de risco da APR
     */
    public function aprRisco()
    {
        return $this->belongsTo(AprRisco::class);
    }

    public function risco()
    {
        return $this->belongsTo(Risco::class, 'risco_id');
    }
}
