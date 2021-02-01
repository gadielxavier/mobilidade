<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProeficienciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proeficiencia', function (Blueprint $table) {
            $table->renameColumn('nome', 'lingua');
            $table->string('nivel');
            $table->integer('nota');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proeficiencia', function (Blueprint $table) {
            $table->dropColumn('nivel');
            $table->dropColumn('nota');
        });
    }
}
