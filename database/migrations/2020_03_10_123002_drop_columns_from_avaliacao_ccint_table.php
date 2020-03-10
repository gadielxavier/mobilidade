<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsFromAvaliacaoCcintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avaliacao_ccint', function($table) {
             $table->dropColumn('participacao');
             $table->dropColumn('representacao_estudantil');
             $table->dropColumn('programa_academico');
          });

        Schema::table('avaliacao_ccint', function($table) {
            $table->float('carta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('avaliacao_ccint', function($table) { 
            $table->float('participacao');
            $table->float('representacao_estudantil');
            $table->float('programa_academico');
          });

         Schema::table('avaliacao_ccint', function($table) {
            $table->dropColumn('carta');
        });
    }
}
