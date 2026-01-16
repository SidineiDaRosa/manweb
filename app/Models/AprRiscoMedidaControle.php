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
        'medida_id',
        'status'
    ];

    public $timestamps = true;
}
