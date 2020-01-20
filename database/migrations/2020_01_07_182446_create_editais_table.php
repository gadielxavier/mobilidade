<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('editais', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fim_inscricao');
            $table->string('nome');
            $table->string('numero');
            $table->integer('qtd_bolsas');
            $table->integer('status_edital_id');
            $table->string('path_anexo');
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
         Schema::dropIfExists('editais');
    }
}
