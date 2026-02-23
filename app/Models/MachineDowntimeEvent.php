<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineDowntimeEvent extends Model
{
    use HasFactory;
    
    protected $table = 'machine_downtime_events';

    protected $fillable = [
        'downtime_id',
        'event_type',
        'event_timestamp',
        'reason_detail',
        'user_id'
    ];

    // Relacionamento com a parada
    public function downtime()
    {
        return $this->belongsTo(MachineDowntime::class, 'downtime_id');
    }

    // Relacionamento com o usuário que realizou o evento
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}