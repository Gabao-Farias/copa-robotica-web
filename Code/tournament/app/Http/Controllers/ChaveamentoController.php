<?php

namespace App\Http\Controllers;

use App\Batalha;
use App\Colocacao;
use App\TorneioConfig;
use Illuminate\Http\Request;

use App\Http\Requests;

class ChaveamentoController extends Controller
{
    public function index()
    {
        $faseTorneio = (int) TorneioConfig::where('nome', 'fase_torneio')->first()->valor;

        if ($faseTorneio < 2) {
            flash()->warning('Ainda não estamos nas quartas de final!');
            return redirect(url('/'));
        }

        $quartas = Batalha::where('fase', 2)
            ->sorteio()->get();
        $semi = Batalha::where('fase', 3)
            ->sorteio()->get();
        $final = Batalha::where('fase', 4)
            ->sorteio()->get();

        $teams = [];
        $results = [[], [], []];
        foreach ($quartas as $batalha)
        {
            $teams[] = array_merge([$batalha->equipe1->nome], [$batalha->equipe2->nome]);
            //Definir resultados das quartas
            $results[0][] = $this->definirResultado($batalha);
        }

        foreach ($semi as $batalha)
        {
            //Definir resultados da semi
            $results[1][] = $this->definirResultado($batalha);
        }

        foreach ($final as $batalha)
        {
            //Definir resultados da final
            $results[2][] = $this->definirResultado($batalha);
        }

        $chaveamento = [
            'init' => [
                'teams' => $teams,
                'results' => $results
            ],

            'teamWidth' => 250,
            'matchMargin' => 50,
            'roundMargin' => 70
        ];

        $hasWinners = (int) (Colocacao::count() == 4);

        return view('chaveamento', compact('chaveamento', 'hasWinners'));
    }

    protected function definirResultado(Batalha $batalha)
    {
        $vencedor = $batalha->equipe_vencedora_id;
        if ($vencedor != null) {
            if ($vencedor == $batalha->equipe1->id) {
                return [1, 0];
            }

            return [0, 1];
        }

        return [null, null];
    }
}
