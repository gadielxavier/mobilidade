<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status_Inscricao extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'status_inscricao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['titulo', 'cabe_recurso', 'visivel'];
}
