<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    protected $fillable = ['nome', 'escola_id', 'foto_equipe_path', 'foto_robo_path', 'presente', 'codigo'];

    public function escola()
    {
    	return $this->belongsTo('App\Escola');
    }

    public function integrantes()
    {
        return $this->hasMany('App\Integrante');
    }

    public function batalhas()
    {
        return $this->hasMany('App\Batalha', 'equipe1_id')->orWhere('equipe2_id', $this->id);
    }

    public function batalhasVencidas()
    {
        return $this->batalhas()->where('equipe_vencedora_id', $this->id);
    }

    public function rounds()
    {
        return $this->hasManyThrough('App\Round', 'App\Batalha', 'equipe1_id')->orWhere('equipe2_id', $this->id);
    }

    public function roundsVencidosBatalha(Batalha $batalha)
    {
        return \App\Round::where(['equipe_vencedora_id' => $this->id, 'batalha_id' => $batalha->id]);
    }

    public function pontos()
    {
        return $this->hasMany('App\PontosRound', 'equipe_id');
    }

    public function pontosRound(Round $round)
    {
        return $this->hasMany('App\PontosRound', 'equipe_id')->where('round_id', $round->id);
    }

    public function pontosBatalha(Batalha $batalha)
    {
        return $this->pontos()->where('batalha_id', $batalha->id);
    }
}
