<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinalizadoToCandidaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidaturas', function($table)
        {
            $table->string('primeira_opcao_universidade')->nullable()->change();
            $table->string('primeira_opcao_curso')->nullable()->change();
            $table->string('primeira_opcao_pais')->nullable()->change();
            $table->string('segunda_opcao_universidade')->nullable()->change();
            $table->string('segunda_opcao_curso')->nullable()->change();
            $table->string('segunda_opcao_pais')->nullable()->change();
            $table->string('terceira_opcao_universidade')->nullable()->change();
            $table->string('terceira_opcao_curso')->nullable()->change();
            $table->string('terceira_opcao_pais')->nullable()->change();
            $table->string('matricula')->nullable()->change();
            $table->string('historico')->nullable()->change();
            $table->string('percentual')->nullable()->change();
            $table->string('curriculum')->nullable()->change();
            $table->string('plano_trabalho1')->nullable()->change();
            $table->string('plano_trabalho2')->nullable()->change();
            $table->string('plano_trabalho3')->nullable()->change();
            $table->string('plano_estudo1')->nullable()->change();
            $table->string('plano_estudo2')->nullable()->change();
            $table->string('plano_estudo3')->nullable()->change();
            $table->string('certificado_proficiencia1')->nullable()->change();
            $table->string('status_id')->nullable()->change();
            $table->string('carta')->nullable()->change();
            $table->string('nome_professor_carta')->nullable()->change();
            $table->string('professor_departamento_id')->nullable()->change();
        });

        Schema::table('candidaturas', function($table) {
            $table->boolean('finalizado');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidaturas', function($table) {
            $table->dropColumn('finalizado');
        });
    }
}
