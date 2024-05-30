<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social', 50)->nullable();
            $table->string('nome_fantasia', 50);
            $table->string('cnpj')->nullable();
            $table->string('insc_estadual')->nullable();
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade');
            $table->string('estado',2);
            $table->string('telefone')->nullable();
            $table->string('contato')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
            $table->string('segmento')->nullable();
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
        Schema::dropIfExists('empresas');
    }
}
