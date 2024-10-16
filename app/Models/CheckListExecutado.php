<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckListExecutado extends Model
{
    use HasFactory;
    protected $table = 'check_list';
    protected $fillable = [
        'check_list_id',
        'equipamento_id',
        'status',
        'descricao',
        'data_verificacao',
        'hora_verificacao'
    ];

    public function checklist()
    {
        return $this->belongsTo(CheckList::class, 'checklist_id');
    }
}
