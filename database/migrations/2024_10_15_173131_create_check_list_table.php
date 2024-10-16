<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_list', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('descricao');
            $table->unsignedBigInteger('equipamento_id');
            $table->foreign('equipamento_id')->references('id')->on('equipamentos');
            $table->integer('intervalo')->nullable();
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
        Schema::dropIfExists('check_list');
    }
}
