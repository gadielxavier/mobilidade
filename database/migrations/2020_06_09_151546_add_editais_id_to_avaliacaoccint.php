<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEditaisIdToAvaliacaoccint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avaliacao_ccint', function($table) {
            $table->integer('edital_id');
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
            $table->dropColumn('edital_id');
        });
    }
}
