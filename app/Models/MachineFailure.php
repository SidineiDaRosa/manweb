<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineFailure extends Model
{
    use HasFactory;

    // Define explicitamente a tabela
    protected $table = 'machine_failures';

    // Campos que podem ser preenchidos em massa
    protected $fillable = ['name', 'description'];
}
