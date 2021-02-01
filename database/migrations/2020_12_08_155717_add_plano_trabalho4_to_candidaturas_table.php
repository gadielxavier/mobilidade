<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanoTrabalho4ToCandidaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidaturas', function($table) {
            $table->string('plano_trabalho4')->nullable();
            $table->string('plano_estudo4')->nullable();
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
            $table->dropColumn('plano_trabalho4');
            $table->dropColumn('plano_estudo4');
        });
    }
}
