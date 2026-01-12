<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventOs extends Model
{
     use HasFactory;
    protected $table = 'event_os';
    protected $fillable = [
        'os_id',
        'acao',
        'user_id',
        'observacao',
    ];


    public function event_os()
    {
        return $this->hasMany(OrdemServico::class);
    }
}
