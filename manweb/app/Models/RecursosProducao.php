<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecursosProducao extends Model
{
    use HasFactory;
    protected $table='recursos_producao';

    public function produto(){
        return $this->belongsTo('App\Models\Produto');
    }

    public function equipamento(){
        return $this->belongsTo('App\Models\Equipamento');
    }

}
