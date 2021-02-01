<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Editais extends Model
{
    use SoftDeletes;
    
	public $timestamps = false;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['inicio_inscricao', 'fim_inscricao', 'homologacoes_inscricoes', 'inicio_recurso_inscricao', 'fim_recurso_inscricao', 'homologacao_final', 'inicio_proeficiencia', 'fim_proeficiencia', 'aprovados_primeira_fase', 'inicio_recurso_primeira_fase', 'fim_recurso_primeira_fase', 'resultado_final_primeira_fase', 'inicio_ccint', 'fim_ccint', 'resultado_segunda_fase', 'inicio_recurso_segunda_fase', 'fim_recurso_segunda_fase', 'resultado_final_segunda_fase', 'reuniao_esclarecimentos', 'inicio_entrega_documentos', 'fim_entrega_documentos', 'inicio_avaliacao_documentos', 'fim_avaliacao_documentos', 'envio_candidaturas', 'inicio_recepcao_carta', 'fim_recepcao_carta', 'divulgacao_resultado_terceira_fase', 'inicio_aquisicoes', 'inicio_mobilidade'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fim_inscricao', 'nome', 'numero', 'qtd_bolsas', 'status_edital_id', 'path_anexo', 'resultado', 'maior_pontuacao', 'inicio_inscricao', 'homologacoes_inscricoes' , 'inicio_recurso_inscricao' , 'fim_recurso_inscricao', 'homologacao_final' , 'inicio_proeficiencia', 'fim_proeficiencia', 'aprovados_primeira_fase', 'inicio_recurso_primeira_fase', 'fim_recurso_primeira_fase', 'resultado_final_primeira_fase', 'inicio_ccint', 'fim_ccint', 'resultado_segunda_fase', 'inicio_recurso_segunda_fase', 'fim_recurso_segunda_fase', 'resultado_final_segunda_fase', 'reuniao_esclarecimentos', 'inicio_entrega_documentos', 'fim_entrega_documentos', 'inicio_avaliacao_documentos', 'fim_avaliacao_documentos', 'envio_candidaturas', 'inicio_recepcao_carta', 'fim_recepcao_carta', 'divulgacao_resultado_terceira_fase', 'inicio_aquisicoes', 'inicio_mobilidade'];

    /**
     * Get the status record associated with the candidatura.
     */
    public function status()
    {
        return $this->belongsTo('App\Status_Edital', 'status_edital_id');
    }

}
