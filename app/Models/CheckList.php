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
        'hora_verificacao'
    ];

    public function executados()
    {
        return $this->hasMany(CheckListExecutado::class, 'checklist_id');
    }
}
