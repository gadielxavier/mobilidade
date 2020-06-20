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
    protected $fillable = ['candidatura_id', 'avaliador_id', 'desempenho_academico', 'plano_trabalho', 'curriculum_lattes', 'carta', 'nota_final', 'finalizado', 'edital_id', 'posicao'];


    /**
     * Get the candidatura record associated with the Avaliacao_Ccint.
     */
    public function candidatura()
    {
        return $this->belongsTo('App\Candidaturas', 'candidatura_id');
    }

    public function avaliador()
    {
        return $this->belongsTo('App\User', 'avaliador_id');
    }
}
