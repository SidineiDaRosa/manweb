<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckListExecutado extends Model
{
    use HasFactory;

    protected $table = 'checklist_executado'; // Nome da tabela

    protected $fillable = [
        'check_list_id',
        'equipamento_id',
        'gravidade',
        'observacao',
        'temperatura',
        'vibracao',
        'data_verificacao',
        'hora_verificacao',
        'funcionario'
    ]; // Campos que podem ser preenchidos em massa (mass assignment)

    // Definição do relacionamento belongsTo com a tabela CheckList
    public function checkList()
    {
        return $this->belongsTo(CheckList::class, 'check_list_id');//liga ao campo check_list_id
    }
}
