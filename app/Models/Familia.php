<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    use HasFactory;
    protected $table = 'familias';
    protected $fillable = [
        'nome',
        'descricao',
        'categoria_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
