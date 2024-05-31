<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateParadasEquipamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paradas_equipamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ordem_producao_id');
            $table->foreign('ordem_producao_id')->references('id')->on('ordens_producoes');
            $table->date('data');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->string('descricao');
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
        Schema::dropIfExists('paradas_equipamentos');
    }
}
