<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convenios extends Model
{
	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['universidade', 'pais', 'proeficiencia_id', 'status'];

    /**
     * Get the proficiencia record associated with the convenio.
     */
    public function proeficiencia()
    {
        return $this->belongsTo('App\Proeficiencia', 'proeficiencia_id');
    }
}
