<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPosicaoToAvaliacaoCcint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Avaliacao_Ccint', function($table) {
            $table->integer('posicao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Avaliacao_Ccint', function($table) {
            $table->integer('posicao');
        });
    }
}
