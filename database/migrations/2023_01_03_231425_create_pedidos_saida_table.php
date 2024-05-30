<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosSaidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_saida', function (Blueprint $table) {
            $table->id();
            $table->date('data_emissao');
            $table->time('hora_emissao');
            $table->date('data_prevista');
            $table->time('hora_prevista');
            $table->unsignedBigInteger('empresa_id')->nullable(); //foreing vem da própria tabela equipamentos
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->unsignedBigInteger('equipamento_id')->nullable(); //foreing vem da própria tabela equipamentos
            $table->foreign('equipamento_id')->references('id')->on('equipamentos');
            $table->unsignedBigInteger('funcionarios_id')->nullable(); //foreing vem da própria tabela equipamentos
            $table->foreign('funcionarios_id')->references('id')->on('funcionarios');
            $table->unsignedBigInteger('fornecedor_id');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
            $table->unsignedBigInteger('ordem_servico_id')->nullable(); //foreing vem da própria tabela ordem seviço
            $table->foreign('ordem_servico_id')->references('id')->on('ordens_servicos');
            $table->string('status', 50);
            $table->string('descricao', 200);
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
        Schema::dropIfExists('pedidos_saida');
    }
}
