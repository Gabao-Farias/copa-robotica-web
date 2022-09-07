<?php

namespace App\Components\Helpers;

class Helpers {
	public function resolverFotoEquipe($equipe)
	{
		$url = $equipe->foto_equipe_path;

		if (is_null($url)) {
			return asset('images/equipe-placeholder.jpg');
		}

		return asset($url);
	}

	public function resolverFotoRobo($equipe)
    {
        $url = $equipe->foto_robo_path;

        if (is_null($url)) {
            return asset('images/robot_placeholder.png');
        }

        return asset($url);
    }

	public function resolverStatusBatalha($status)
	{
		return config('torneio.status_batalha.' . $status);
	}

	public function resolverStatusRound($status)
	{
		return config('torneio.status_round.' . $status);
	}
}