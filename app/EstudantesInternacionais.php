<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstudantesInternacionais extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'estudantes_internacionais';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'pais', 'programa', 'modalidade', 'inicio', 'final'];
}
