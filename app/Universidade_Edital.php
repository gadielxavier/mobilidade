<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Universidade_Edital extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'universidade_edital';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'vagas', 'edital_id'];

    /**
     * Get the convenio record associated with the universidade.
     */
    public function convenio()
    {
        return $this->hasOne('App\Convenios', 'universidade', 'nome');
    }
}
