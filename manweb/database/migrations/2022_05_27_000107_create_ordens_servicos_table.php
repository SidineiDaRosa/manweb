<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordens_servicos', function (Blueprint $table) {
            $table->id();
            $table->date('data_emissao')->nullable();
            $table->time('hora_emissao')->nullable();
            /*--------------------------------------------------*/
            $table->date('data_inicio')->nullable();
            $table->time('hora_inicio')->nullable();
            /*--------------------------------------------------*/
            $table->date('data_fim')->nullable();
            $table->time('hora_fim')->nullable();
            /*--------------------------------------------------*/
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->unsignedBigInteger('equipamento_id');
            $table->foreign('equipamento_id')->references('id')->on('equipamentos');
            $table->string('emissor');
            $table->string('responsavel');
            $table->string('descricao');
            $table->string('Executado');
            $table->integer('status_servicos',2);
            $table->string('link_foto',200);
            $table->integer('gravidade',1);
            $table->integer('urgencia',1);
            $table->integer('tendencia',1);
            $table->deciam('valor',9,2);
            $table->string('situacao');

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
        Schema::dropIfExists('ordens_servicos');
    }
}
