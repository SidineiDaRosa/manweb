<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaLocal extends Model
{
    use HasFactory;

    protected $table = 'area_local';

 
    protected $fillable = [
        'nome',//nome setor
        'descricao'
    ];

    // Relação: Um local pode ter várias APRs
    public function aprs()
    {
        return $this->hasMany(Apr::class, 'localizacao_id');
    }
}
