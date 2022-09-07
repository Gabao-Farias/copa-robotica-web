<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batalha_id')->unsigned();
            $table->enum('status', ['nao_iniciada', 'em_andamento', 'parada', 'concluida'])->default('nao_iniciada');
            $table->integer('ringue_id')->unsigned();
            $table->integer('equipe_vencedora_id')->unsigned()->nullable();
            $table->integer('ordem')->unsigned();
            $table->integer('tempo_restante')->unsigned()->default(config('torneio.duracao_round'));
            $table->timestamp('inicio')->nullable();
            $table->timestamp('fim')->nullable();
            $table->timestamp('ultimo_inicio')->nullable();
            $table->timestamp('ultima_parada')->nullable();
            $table->timestamps();

            $table->foreign('batalha_id')
                    ->references('id')
                    ->on('batalhas')
                    ->onDelete('cascade');

            $table->foreign('ringue_id')
                    ->references('id')
                    ->on('ringues')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rounds');
    }
}
