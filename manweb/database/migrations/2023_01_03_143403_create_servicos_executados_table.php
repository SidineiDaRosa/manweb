<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicosExecutadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicos_executados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ordem_servico_id')->nullable(); //foreing vem da própria tabela equipamentos
            $table->foreign('ordem_servico_id')->references('id')->on('ordens_servicos');
            $table->date('data_inicio');
            $table->time('hora_inicio');
            $table->date('data_fim');
            $table->time('hora_fim');
            $table->unsignedBigInteger('funcionario_id')->nullable(); //foreing vem da própria tabela equipamentos
            $table->foreign('funcionario_id')->references('id')->on('funcionarios');
            $table->string('descricao',300);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicos_executados');
    }
}
