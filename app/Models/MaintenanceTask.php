<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'user_id',
        'title',
        'description',
        'maintenance_type',
        'priority',
        'status',
        'scheduled_at',
        'started_at',
        'completed_at',
        'estimated_hours',
        'actual_hours',
    ];

    protected $casts = [
        'scheduled_at'   => 'datetime',
        'started_at'     => 'datetime',
        'completed_at'   => 'datetime',
        'estimated_hours'=> 'float',
        'actual_hours'   => 'float',
    ];
}
