<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineDowntime extends Model
{
    use HasFactory;

    protected $table = 'machine_downtime';

    protected $fillable = [
        'equipment_id',
        'ordem_servico_id',
        'started_at',
        'ended_at',
        'reason',
        'failure_id',
        'user_id',
        'ended_user_id',
        'subcategoria_id'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    // 🔹 Relacionamento com Equipamento
    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class, 'equipment_id');
    }

    // 🔹 Relacionamento com Ordem de Serviço
    public function ordemServico()
    {
        return $this->belongsTo(OrdemServico::class, 'ordem_servico_id');
    }
    public function failure()
    {
        return $this->belongsTo(MachineFailure::class, 'failure_id');
    }

    public function startedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function endedBy()
    {
        return $this->belongsTo(User::class, 'ended_user_id');
    }
    public function machine_failure_subcategorie()
    {
        return $this->belongsTo(MachineFailureSubcategory::class, 'subcategoria_id');
    }
}
