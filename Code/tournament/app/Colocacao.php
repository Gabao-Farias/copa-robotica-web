<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colocacao extends Model
{
    protected $fillable = ['equipe_id', 'colocacao'];

    public function equipe()
    {
        return $this->belongsTo('App\Equipe');
    }
}
