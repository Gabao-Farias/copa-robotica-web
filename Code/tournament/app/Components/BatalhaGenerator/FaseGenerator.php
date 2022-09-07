<?php

namespace App\Components\BatalhaGenerator;

use App\Batalha;
use App\Components\Ranking\Ranking;
use App\TorneioConfig;
use DB;

class FaseGenerator
{
    public function resetar()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS=0;");
        \App\PontosRound::truncate();
        \App\Round::truncate();
        \App\Batalha::truncate();
        \App\Colocacao::truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS=1;");
    }

    public function gerarPrimeiraFase()
    {
        $this->resetar();

        TorneioConfig::where('nome', 'fase_torneio')->update(['valor' => 1]);

        $gerador = new BatalhaGenerator;

        $gerador->gerarBatalhasCondicao();
        $gerador->complementarBatalhas();

        $this->salvar($gerador->getBatalhas(), $fase = 1);
    }

    public function gerarQuartasDeFinal()
    {
        $ranking = with(new Ranking)->listarSemRestricao();
        $equipes = $ranking->pluck('equipe')->pluck('id')->toArray();

        $ordemEquipes = [
            $equipes[0], $equipes[7], $equipes[2], $equipes[4], $equipes[3], $equipes[5], $equipes[1], $equipes[6]
        ];

        $ordemEquipes = array_combine($ordemEquipes, $ordemEquipes);

        $gerador = new BatalhaGenerator;
        $gerador->setEquipes($ordemEquipes);
        $gerador->gerarBatalhasSequencia();

        $this->salvar($gerador->getBatalhas(), $fase = 2);
    }

    public function salvar(array $batalhas, $fase, $ordem = 1)
    {
        foreach ($batalhas as $batalha)
        {
            Batalha::create([
                'equipe1_id' => $batalha['equipe1'],
                'equipe2_id' => $batalha['equipe2'],
                'fase' => $fase,
                'ordem_sorteio' => $ordem++
            ]);
        }
    }
}