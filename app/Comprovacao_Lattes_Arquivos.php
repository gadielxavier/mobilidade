<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprovacao_Lattes_Arquivos extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comprovacao_lattes_arquivos';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['candidatura_id', 'arquivo'];
}
