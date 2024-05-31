<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePecasEquipamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pecas_equipamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->unsignedBigInteger('equipamento')->nullable(); //foreing vem da própria tabela equipamentos
            $table->foreign('equipamento')->references('id')->on('equipamentos');
            $table->decimal('quantidade');
            $table->date('data_substituicao');
            $table->time('hora_substituicao');
            $table->integer('intervalo_manutencao')->nullable();
            $table->date('data_proxima_manutencao');
            $table->date('hora_proxima_manutencao');
            $table->integer('horimetro')->nullable();
            $table->integer('forma_medicao')->nullable();
            $table->string('status', 10);
            $table->string('link_peca', 200);
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
        Schema::dropIfExists('pecas_equipamentos');
    }
}
