<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineFailureSubcategory extends Model
{
    use HasFactory;

    protected $table = 'machine_failure_subcategories';

    protected $fillable = [
        'machine_failure_id',
        'name',
        'description',
        'active'
    ];

    public function failurecategory()
    {
        return $this->belongsTo(MachineFailure::class, 'machine_failure_id');
    }
}