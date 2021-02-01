<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCandidaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidaturas', function($table) {
            $table->string('quarta_opcao_universidade')->nullable();
            $table->string('quarta_opcao_curso')->nullable();
            $table->string('quarta_opcao_pais')->nullable();
            $table->string('nome_professor_carta');
            $table->integer('professor_departamento_id');
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
            $table->dropColumn('quarta_opcao_universidade');
            $table->dropColumn('quarta_opcao_curso');
            $table->dropColumn('quarta_opcao_pais');
            $table->dropColumn('nome_professor_carta');
            $table->dropColumn('professor_departamento_id');
        });
    }
}
