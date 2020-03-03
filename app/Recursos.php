<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recursos extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['candidato_id', 'edital_id', 'description', 'replied'];

   /**
     * Get the edital record associated with the candidatura.
     */
    public function edital()
    {
        return $this->belongsTo('App\Editais', 'edital_id');
    }

    /**
     * Get the candidato record associated with the candidatura.
     */
    public function candidato()
    {
        return $this->belongsTo('App\Candidato', 'candidato_id');
    }
}
