<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batalha extends Model
{
    protected $fillable = ['equipe1_id', 'equipe2_id', 'fase', 'ordem_sorteio'];
    protected $with = ['equipe1', 'equipe2'];

    public function equipe1() {
        return $this->belongsTo('App\Equipe', 'equipe1_id', 'id');
    }

    public function equipe2() {
        return $this->belongsTo('App\Equipe', 'equipe2_id', 'id');
    }

    public function rounds()
    {
        return $this->hasMany('App\Round');
    }

    public function pontos()
    {
        return $this->hasMany('App\PontosRound');
    }

    public function scopeSorteio($query)
    {
        return $query->orderBy('ordem_sorteio', 'asc');
    }

    public function scopeStatus($query)
    {
        return $query->orderBy('status', 'asc');
    }
}
