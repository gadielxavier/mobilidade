<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatesToEditaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editais', function($table) {
            $table->date('inicio_inscricao');
            $table->date('homologacoes_inscricoes');
            $table->date('inicio_recurso_inscricao');
            $table->date('fim_recurso_inscricao');
            $table->date('homologacao_final');
            $table->date('inicio_proeficiencia');
            $table->date('fim_proeficiencia');
            $table->date('aprovados_primeira_fase');
            $table->date('inicio_recurso_primeira_fase');
            $table->date('fim_recurso_primeira_fase');
            $table->date('resultado_final_primeira_fase');
            $table->date('inicio_ccint');
            $table->date('fim_ccint');
            $table->date('resultado_segunda_fase');
            $table->date('inicio_recurso_segunda_fase');
            $table->date('fim_recurso_segunda_fase');
            $table->date('resultado_final_segunda_fase');
            $table->date('reuniao_esclarecimentos');
            $table->date('inicio_entrega_documentos');
            $table->date('fim_entrega_documentos');
            $table->date('inicio_avaliacao_documentos');
            $table->date('fim_avaliacao_documentos');
            $table->date('envio_candidaturas');
            $table->date('inicio_recepcao_carta');
            $table->date('fim_recepcao_carta');
            $table->date('divulgacao_resultado_terceira_fase');
            $table->date('inicio_aquisicoes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('editais', function($table) {
            $table->dropColumn('inicio_inscricao');
            $table->dropColumn('homologacoes_inscricoes');
            $table->dropColumn('inicio_recurso_inscricao');
            $table->dropColumn('fim_recurso_inscricao');
            $table->dropColumn('homologacao_final');
            $table->dropColumn('inicio_proeficiencia');
            $table->dropColumn('fim_proeficiencia');
            $table->dropColumn('aprovados_primeira_fase');
            $table->dropColumn('inicio_recurso_primeira_fase');
            $table->dropColumn('fim_recurso_primeira_fase');
            $table->dropColumn('resultado_final_primeira_fase');
            $table->dropColumn('inicio_ccint');
            $table->dropColumn('fim_ccint');
            $table->dropColumn('resultado_segunda_fase');
            $table->dropColumn('inicio_recurso_segunda_fase');
            $table->dropColumn('fim_recurso_segunda_fase');
            $table->dropColumn('resultado_final_segunda_fase');
            $table->dropColumn('reuniao_esclarecimentos');
            $table->dropColumn('inicio_entrega_documentos');
            $table->dropColumn('fim_entrega_documentos');
            $table->dropColumn('inicio_avaliacao_documentos');
            $table->dropColumn('fim_avaliacao_documentos');
            $table->dropColumn('envio_candidaturas');
            $table->dropColumn('inicio_recepcao_carta');
            $table->dropColumn('fim_recepcao_carta');
            $table->dropColumn('divulgacao_resultado_terceira_fase');
            $table->dropColumn('inicio_aquisicoes');
        });
    }
}
