<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistExecutadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_executado', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('check_list_id');
            $table->foreign('check_list_id')->references('id')->on('check_list');
            $table->unsignedBigInteger('equipamento_id');
            $table->foreign('equipamento_id')->references('id')->on('equipamentos');
            $table->integer('status');
            $table->string('descricao');
            $table->date('data_verificacao')->nullable();
            $table->time('hora_verificacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklist_executado');
    }
}
