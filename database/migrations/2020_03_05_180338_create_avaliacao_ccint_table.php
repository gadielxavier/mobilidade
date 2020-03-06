<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliacaoCcintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Avaliacao_Ccint', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidatura_id');
            $table->integer('avaliador_id');
            $table->float('desempenho_academico');
            $table->float('plano_trabalho');
            $table->float('curriculum_lattes');
            $table->float('participacao');
            $table->float('representacao_estudantil');
            $table->float('programa_academico');
            $table->float('nota_final');
            $table->boolean('finalizado');
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
        Schema::dropIfExists('Avaliacao_Ccint');
    }
}
