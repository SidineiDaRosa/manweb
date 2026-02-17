<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    // Define a tabela explicitamente (opcional se seguir convenção)
    protected $table = 'user_roles';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'descricao',
        'user_id',
        'level'
        
    ];

    // Relacionamento com User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
