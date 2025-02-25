<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitacaoOsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('solicitacao_os')) { // Verifica se a tabela já existe
            Schema::create('solicitacao_os', function (Blueprint $table) {
                $table->id(); // ID auto-incremental
                $table->dateTime('datatime'); // Data e hora
                $table->unsignedBigInteger('emissor')->nullable(); // Chave estrangeira opcional
                $table->foreign('emissor')->references('id')->on('funcionarios'); // Relacionamento com a tabela funcionarios
                $table->string('descricao', 300); // Campo de descrição com limite de 300 caracteres
                $table->timestamps(); // Campos created_at e updated_at
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('solicitacao_os')) { // Verifica antes de excluir
            Schema::dropIfExists('solicitacao_os');
        }
    }
}

