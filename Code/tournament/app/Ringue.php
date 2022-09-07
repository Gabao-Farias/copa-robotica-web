<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ringue extends Model
{
    protected $fillable = ['nome'];

    public function round()
    {
    	return $this->hasOne('App\Round')->where('status', '!=', 'concluida');
    }

    public function roundAtivo()
    {
        return $this->hasOne('App\Round')->whereIn('status', ['em_andamento', 'parada']);
    }

    public function scopeDisponivel($query)
    {
    	return $query->doesntHave('round');
    }
}
