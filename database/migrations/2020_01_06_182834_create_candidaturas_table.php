<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('candidaturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidato_id');
            $table->integer('edital_id');
            $table->string('primeira_opcao_universidade');
            $table->string('primeira_opcao_curso');
            $table->string('primeira_opcao_pais');
            $table->string('segunda_opcao_universidade');
            $table->string('segunda_opcao_curso');
            $table->string('segunda_opcao_pais');
            $table->string('terceira_opcao_universidade');
            $table->string('terceira_opcao_curso');
            $table->string('terceira_opcao_pais');
            $table->string('matricula');
            $table->string('historico');
            $table->string('percentual');
            $table->string('curriculum');
            $table->string('plano_trabalho1');
            $table->string('plano_trabalho2');
            $table->string('plano_trabalho3');
            $table->string('plano_estudo1');
            $table->string('plano_estudo2');
            $table->string('plano_estudo3');
            $table->string('certificado');
            $table->string('status');
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
        Schema::dropIfExists('candidaturas');
    }
}
