<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avaliacao_Ccint extends Model
{

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'avaliacao_ccint';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['candidatura_id', 'avaliador_id', 'desempenho_academico', 'plano_trabalho', 'curriculum_lattes', 'participacao', 'representacao_estudantil', 'programa_academico', 'nota_final', 'finalizado'];


    /**
     * Get the candidatura record associated with the Avaliacao_Ccint.
     */
    public function candidatura()
    {
        return $this->belongsTo('App\Candidaturas', 'candidatura_id');
    }
}
