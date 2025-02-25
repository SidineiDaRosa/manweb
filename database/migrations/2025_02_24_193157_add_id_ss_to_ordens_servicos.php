<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSolicitacaoOsIdToOrdensServicos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordens_servicos', function (Blueprint $table) {
            // Adiciona a coluna como chave estrangeira
            $table->unsignedBigInteger('solicitacao_os_id')->nullable()->after('id');

            // Adiciona a restrição de chave estrangeira
            $table->foreign('solicitacao_os_id')->references('id')->on('solicitacao_os')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordens_servicos', function (Blueprint $table) {
            // Remove a foreign key antes de remover a coluna
            $table->dropForeign(['solicitacao_os_id']);
            $table->dropColumn('solicitacao_os_id');
        });
    }
}
