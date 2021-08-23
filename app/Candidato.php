<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'candidatos';

    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'sexo', 'matricula', 'cpf', 'rg', 'orgao_expedidor', 'data_nascimento', 'curso', 'celular', 'user_id', 'email', 'foto_perfil', 'cotista'];

}
