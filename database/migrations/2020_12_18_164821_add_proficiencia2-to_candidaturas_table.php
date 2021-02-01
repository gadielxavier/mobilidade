<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProficiencia2ToCandidaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidaturas', function (Blueprint $table) {
            $table->renameColumn('certificado', 'certificado_proficiencia1');
            $table->renameColumn('proeficienciaId', 'proficiencia_id');
        });

        Schema::table('candidaturas', function($table) {
            $table->string('certificado_proficiencia2')->nullable();
            $table->string('certificado_proficiencia3')->nullable();
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
            $table->dropColumn('certificado_proficiencia1');
            $table->dropColumn('certificado_proficiencia2');
            $table->dropColumn('certificado_proficiencia3');
            $table->dropColumn('proficiencia_id');
        });
    }
}
