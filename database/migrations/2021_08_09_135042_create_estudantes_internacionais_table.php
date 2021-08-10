<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstudantesInternacionaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudantes_internacionais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('pais');
            $table->string('programa');
            $table->string('modalidade');
            $table->date('inicio')->nullable();
            $table->date('final')->nullable();
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
        Schema::dropIfExists('estudantes_internacionais');
    }
}
