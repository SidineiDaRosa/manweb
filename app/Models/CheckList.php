<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    use HasFactory;
    protected $table = 'check_list';
    protected $fillable = [
        'descricao',
        'equipamento_id',
        'intervalo',
        'data_verificacao',
        'hora_verificacao',
        'natureza'
    ];

    public function check_list()
    {
        return $this->hasMany(CheckListExecutado::class, 'checklist_id');//
    }
    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class, 'equipamento_id');
    }
    
}
