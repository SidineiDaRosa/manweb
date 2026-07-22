<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    use HasFactory;

    protected $table = 'dispositivos';

    protected $fillable = [
        'equipamento_id',
        'device_id',
        'nome',
        'api_key',
        'mac_address',
        'modelo',
        'firmware_versao',
        'intervalo_envio',
        'ultimo_ip',
        'ultima_conexao',
        'status_online',
        'ativo',
    ];

    protected $casts = [
        'ultima_conexao' => 'datetime',
        'status_online' => 'boolean',
        'ativo' => 'boolean',
        'intervalo_envio' => 'integer',
    ];

    /**
     * Equipamento monitorado por este dispositivo.
     */
    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class, 'equipamento_id');
    }
}