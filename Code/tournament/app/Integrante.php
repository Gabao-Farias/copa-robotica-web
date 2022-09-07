<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Integrante extends Model
{
    protected $fillable = ['nome', 'equipe_id', 'capitao'];

    public function equipe()
    {
        return $this->belongsTo('App\Equipe');
    }
}
