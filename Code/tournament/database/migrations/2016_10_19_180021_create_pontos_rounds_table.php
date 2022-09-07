<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePontosRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pontos_rounds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('round_id')->unsigned();
            $table->integer('equipe_id')->unsigned();
            $table->integer('batalha_id')->unsigned();
            $table->enum('tipo_ponto', ['ippon', 'waza_ari', 'yuko', 'koka', 'koka_oponente', 'yusei_gashi', 'yusei_gashi_oponente', 'vitoria']);
            $table->integer('pontos')->unsigned();
            $table->timestamps();

            $table->foreign('round_id')
                    ->references('id')
                    ->on('rounds')
                    ->onDelete('cascade');

            $table->foreign('equipe_id')
                    ->references('id')
                    ->on('equipes')
                    ->onDelete('cascade');

            $table->foreign('batalha_id')
                ->references('id')
                ->on('batalhas')
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
        Schema::dropIfExists('pontos_rounds');
    }
}
