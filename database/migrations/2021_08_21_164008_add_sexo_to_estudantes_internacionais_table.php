<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSexoToEstudantesInternacionaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estudantes_internacionais', function (Blueprint $table) {
            $table->string('sexo')->default('Masculino');
            $table->string('vinculo')->default('Departamento de Ciências Exatas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estudantes_internacionais', function (Blueprint $table) {
            $table->dropColumn('sexo');
            $table->dropColumn('vinculo');
        });
    }
}
