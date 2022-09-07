<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $fillable = ['equipe_id', 'vitorias', 'ippons', 'pontos'];
    protected $with = ['equipe'];

    public function equipe()
    {
        return $this->belongsTo('App\Equipe');
    }
}