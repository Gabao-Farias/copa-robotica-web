<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatalhasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batalhas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('equipe1_id')->unsigned();
            $table->integer('equipe2_id')->unsigned();
            $table->integer('equipe_vencedora_id')->unsigned()->nullable();
            $table->integer('equipe_perdedora_id')->unsigned()->nullable();
            $table->boolean('vencedor_sorteado')->default(0);
            $table->integer('fase')->unsigned();
            $table->integer('ordem_sorteio')->unsigned()->nullable();
            $table->enum('status', ['nao_iniciada', 'em_andamento', 'concluida'])->default('nao_iniciada');
            $table->timestamp('inicio')->nullable();
            $table->timestamp('fim')->nullable();
            $table->timestamps();

            $table->foreign('equipe1_id')
                    ->references('id')
                    ->on('equipes')
                    ->onDelete('cascade');

            $table->foreign('equipe2_id')
                    ->references('id')
                    ->on('equipes')
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
        Schema::dropIfExists('batalhas');
    }
}
