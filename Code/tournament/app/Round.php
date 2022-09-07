<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = ['batalha_id', 'status', 'inicio', 'fim', 'ringue_id', 'ordem', 'tempo_restante'];
    protected $with = ['batalha'];

    public function batalha()
    {
    	return $this->belongsTo('App\Batalha');
    }

    public function ringue()
    {
    	return $this->belongsTo('App\Ringue');
    }

    public function pontos()
    {
        return $this->hasMany('App\PontosRound');
    }

    public function vencedor()
    {
        return $this->belongsTo('App\Equipe', 'equipe_vencedora_id');
    }

    public function scopeAtivo($query)
    {
        return $query->whereIn('status', ['em_andamento', 'parada']);
    }

    public function scopeConcluido($query)
    {
        return $query->where('status', 'concluida');
    }

    public function scopeOrdem($query)
    {
        return $query->orderBy('ordem', 'asc');
    }
}
