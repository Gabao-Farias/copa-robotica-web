<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    protected $fillable = ['nome', 'cidade'];

    public function equipes()
    {
    	return $this->hasMany('App\Equipe');
    }
}
