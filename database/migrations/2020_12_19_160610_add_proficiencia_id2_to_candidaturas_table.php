<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProficienciaId2ToCandidaturasTable extends Migration
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
            $table->string('proficiencia_id')->nullable()->change();
        });

        Schema::table('candidaturas', function($table) {
            $table->string('proficiencia_id2')->nullable();
            $table->string('proficiencia_id3')->nullable();
        });

        Schema::table('candidaturas', function (Blueprint $table) {
            $table->renameColumn('proficiencia_id', 'proficiencia_id1');
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
            $table->dropColumn('proficiencia_id1');
            $table->dropColumn('proficiencia_id2');
            $table->dropColumn('proficiencia_id3');
        });
    }
}
