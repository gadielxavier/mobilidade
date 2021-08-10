<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'tipo'];
}
