<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PecasEquipamentos extends Model
{
    use HasFactory;
    protected $table = 'pecas_equipamentos';
    protected $fillable = [
        'produto_id',
        'equipamento',
        'quantidade',
        'data_substituicao',
        'hora_substituicao',
        'intervalo_manutencao',
        'data_proxima_manutencao',
        'horas_proxima_manutencao',
        'horimetro',
        'forma_medicao',
        'status',
        'tipo_componente',
        'criticidade',
       
    ];

    public function equipamento(){
        return $this->belongsTo('App\Models\Equipamento');
    }
    public function produto(){
        return $this->belongsTo('App\Models\Produto');//busca regsitro atraves do modulo produtos
    }
    
}
