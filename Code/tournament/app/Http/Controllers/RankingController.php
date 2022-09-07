<?php

namespace App\Http\Controllers;

use App\Components\Ranking\Ranking;
use App\Http\Requests;
use App\TorneioConfig;

class RankingController extends Controller
{
    public function index()
    {
        $faseTorneio = (int) TorneioConfig::where('nome', 'fase_torneio')->first()->valor;

        $rankings = with(new Ranking)->listarSemRestricao(false);
        $totalEquipes = $rankings->count();
        $porPagina = ceil($totalEquipes / 2);
        $rankings1 = $rankings->take($porPagina);
        $rankings2 = $rankings->take(($totalEquipes % 2 == 0) ? -$porPagina : -($porPagina - 1));

        $counter1 = 1;
        $counter2 = $counter1 + $rankings1->count();

        return view('ranking',
            compact('rankings1', 'rankings2', 'counter1', 'counter2', 'faseTorneio'));
    }
}
