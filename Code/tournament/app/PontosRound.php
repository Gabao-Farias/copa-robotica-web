<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PontosRound extends Model
{
    protected $fillable = ['round_id', 'equipe_id', 'batalha_id', 'tipo_ponto', 'pontos'];
    protected $with = ['equipe'];

    public function round()
    {
        return $this->belongsTo('App\Round');
    }

    public function equipe()
    {
        return $this->belongsTo('App\Equipe');
    }
}
