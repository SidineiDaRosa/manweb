<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('cod_fabricante',100);
            $table->string('nome', 100);
            $table->text('descricao')->nullable();
            $table->unsignedBigInteger('marca_id');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->unsignedBigInteger('unidade_medida_id');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('unidade_medida_id')->references('id')->on('unidades_medida');
            $table->integer('estoque_minimo')->nullable();
            $table->integer('estoque_ideal')->nullable();
            $table->integer('estoque_maximo')->nullable();
            $table->string('link_peca',200)->after('estoque_maximo');
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
        Schema::dropIfExists('produtos');
    }
}
