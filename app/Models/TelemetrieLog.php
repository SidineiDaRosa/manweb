<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelemetrieLog extends Model
{
    use HasFactory;

    // Define o nome exato da tabela que criamos no banco de dados
    protected $table = 'telemetrie_logs';

    // Desativa os timestamps automáticos do Eloquent (created_at e updated_at gerados pelo Laravel), 
    // já que configuramos o MySQL para gerar o 'created_at' automaticamente via CURRENT_TIMESTAMP
    public $timestamps = false;

    // Campos autorizados para gravação em massa (Mass Assignment)
    protected $fillable = [
        'dispositivo_id',
        'temperatura',
        'horimetro',      // 🟢 ADICIONADO: Autoriza o salvamento do horímetro
        'vibracao',       // 🟢 ADICIONADO: Autoriza o salvamento da vibração RMS
        'status_leitura',
        'codigo_erro',
        'mensagem_erro',
        'voltagem_bateria',
        'rssi',
        'created_at'
    ];
}
