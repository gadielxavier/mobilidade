<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resposta_Recurso extends Model
{

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'resposta_recursos';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['recurso_id', 'description'];
}
