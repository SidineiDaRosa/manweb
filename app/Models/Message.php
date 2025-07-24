<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',   // adiciona user_id aqui
        'name',
        'email',
        'subject',
        'message',
    ];

    // Opcional: relacionamento com o usuário (assumindo que tem model User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
