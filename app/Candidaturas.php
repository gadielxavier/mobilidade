<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidaturas extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['candidato_id', 'edital_id', 'primeira_opcao_universidade', 'primeira_opcao_curso', 'primeira_opcao_pais', 'segunda_opcao_universidade', 'segunda_opcao_curso', 'segunda_opcao_pais', 'terceira_opcao_universidade', 'terceira_opcao_curso', 'terceira_opcao_pais', 'matricula', 'historico', 'percentual', 'curriculum', 'plano_trabalho1', 'plano_trabalho2', 'plano_trabalho3', 'plano_estudo1', 'plano_estudo2', 'plano_estudo3', 'certificado_proficiencia1', 'status_id', 'carta', 'desempenho', 'proficiencia_id1', 'quarta_opcao_universidade', 'quarta_opcao_curso', 'quarta_opcao_pais', 'nome_professor_carta', 'professor_departamento_id', 'plano_trabalho4', 'plano_estudo4', 'ies_anfitria', 'certificado_proficiencia2', 'certificado_proficiencia3', 'proficiencia_id2', 'proficiencia_id3', 'finalizado'];

    /**
     * Get the edital record associated with the candidatura.
     */
    public function edital()
    {
        return $this->belongsTo('App\Editais', 'edital_id');
    }

    /**
     * Get the status record associated with the candidatura.
     */
    public function status()
    {
        return $this->belongsTo('App\Status_Inscricao', 'status_id');
    }

    /**
     * Get the candidato record associated with the candidatura.
     */
    public function candidato()
    {
        return $this->belongsTo('App\Candidato', 'candidato_id');
    }

    /**
     * Get the departamento record associated with the candidatura.
     */
    public function departamento()
    {
        return $this->belongsTo('App\Departamento', 'professor_departamento_id');
    }

    /**
     * Get the convenio record associated with the candidatura.
     */
    public function convenio()
    {
        return $this->belongsTo('App\Convenios', 'ies_anfitria' , 'universidade');
    }

}
