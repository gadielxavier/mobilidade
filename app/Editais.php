<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Editais extends Model
{
	public $timestamps = false;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['fim_inscricao'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fim_inscricao', 'nome', 'numero', 'qtd_bolsas', 'status_edital_id', 'path_anexo', 'resultado'];

    /**
     * Get the status record associated with the candidatura.
     */
    public function status()
    {
        return $this->belongsTo('App\Status_Edital', 'status_edital_id');
    }

}
