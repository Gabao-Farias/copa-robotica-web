<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('codigo')->unsigned();
            $table->string('nome')->unique();
            $table->integer('escola_id')->unsigned();
            $table->string('foto_equipe_path')->nullable();
            $table->string('foto_robo_path')->nullable();
            $table->boolean('presente')->default(1);
            $table->timestamps();

           $table->foreign('escola_id')
               ->references('id')
               ->on('escolas')
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
        Schema::dropIfExists('equipes');
    }
}
