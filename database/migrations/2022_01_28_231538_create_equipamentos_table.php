<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->unsignedBigInteger('marca_id');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->string('modelo')->nullable();
            $table->float('potencia', 8,2)->nullable();//tipo de potência(cv, wats, toneladas por hora etc)
            $table->string('tipo_potencia')->nullable();
            $table->date('data_fabricacao')->nullable();
            $table->unsignedBigInteger('equipamento_pai')->nullable();//foreing vem da própria tabela equipamentos
            $table->foreign('equipamento_pai')->references('id')->on('equipamentos');
            $table->unsignedBigInteger('combustivel')->nullable();//combustivel usado no equipamento
            $table->foreign('combustivel')->references('id')->on('produtos');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipamentos');
    }
}
