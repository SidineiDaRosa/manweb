<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;
    protected $table='equipamentos';
    protected $fillable =[
        'nome',
        'descricao',
        'marca_id',
        'modelo',
        'potencia',
        'tipo_potencia',
        'data_fabricacao',
        'data_instalacao',
        'data_desativacao',
        'equipamento_pai',
        'combustivel',
        'empresa_id',
        'tipo_de_ativo',
        'estado_do_ativo',
        'criticidade',
        'localizacao',
        'valor_estimado',
        'anexo_1',
        'anexo_2'
    ];

    public function marca()
    {
        return $this->belongsTo('\App\Models\Marca', 'marca_id', 'id');
    }
    public function maquina()
    {
        return $this->belongsTo('\App\Models\Maquina', 'maquina_id', 'id');
    }
    public function equip_pai()
    {
        return $this->belongsTo('\App\Models\Equipamento', 'equipamento_pai', 'id');
    }
    public function Empresa()
    {
        return $this->belongsTo('App\Models\Empresas');
    }
    public function equipamentos()
    {
        return $this->belongsTo('App\Models\PecasEquipamentos');
    }
}
