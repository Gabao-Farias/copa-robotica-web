<?php

namespace App\Components\BatalhaGenerator;

use App\Batalha;
use App\Colocacao;
use App\Components\Ranking\Ranking;
use App\Events\EndFaseInicialEvent;
use App\Events\UpdateChaveamentoEvent;
use App\TorneioConfig;

class FaseHandler
{
    public function verificarFase()
    {
        $faseAtual = (int) TorneioConfig::where('nome', 'fase_torneio')->first()->valor;
        $metodo = 'verificar' . studly_case(config('torneio.fases_torneio.' . $faseAtual));
        $this->{$metodo}();
    }

    protected function verificarPrimeiraFase()
    {
        //Atualiza o ranking da primeira fase.
        with(new Ranking)->atualizar();

        $countBatalhas = Batalha::where('fase', 1)->count();
        $countConcluidas = Batalha::where(['fase' => 1, 'status' => 'concluida'])->count();

        //Se todas as batalhas da primeira fase foram concluidas
        //deve-se gerar batalhas das quartas de final.
        if ($countBatalhas == $countConcluidas) {
            with(new FaseGenerator)->gerarQuartasDeFinal();
            $this->atualizarFase($faseAtual = 1);
        }
    }

    protected function verificarQuartasDeFinal()
    {
        //Obter batalhas já geradas da semi final
        $batalhasSemi = Batalha::where('fase', 3)->get();
        //Quais equipes devem ser removidas da busca nas quartas.
        $equipesRemove = array_unique(array_merge($batalhasSemi->pluck('equipe1_id')->toArray(), $batalhasSemi->pluck('equipe2_id')->toArray()));

        //Obter batalhas com vencedor das quartas de final.
        $batalhasVencidas = Batalha::where('equipe_vencedora_id', '!=', null)
            ->where('fase', 2)
            ->whereNotIn('equipe1_id', $equipesRemove)
            ->whereNotIn('equipe2_id', $equipesRemove)
            ->get();

        //Se houver um número par de batalhas com vencedor, pode-se gerar
        //uma batalha para a semi final.
        if (($batalhasVencidas->count() % 2) == 0) {
            $equipes = $batalhasVencidas->pluck('equipe_vencedora_id', 'equipe_vencedora_id')->toArray();

            $gerador = new BatalhaGenerator;
            $gerador->setEquipes($equipes);
            $gerador->gerarBatalhasSequencia();
            with(new FaseGenerator)->salvar($gerador->getBatalhas(), 3, $batalhasSemi->count());
        }

        //Se todas as batalhas das quartas foram finalizadas, deve-se passar para
        //a semi final.
        $countBatalhas = Batalha::where('fase', 2)->count();
        $countConcluidas = Batalha::where('fase', 2)
            ->where('status', 'concluida')
            ->count();

        //Ir para a próxima fase.
        if ($countBatalhas == $countConcluidas) {
            $this->atualizarFase($fase = 2);
        }

        event(new UpdateChaveamentoEvent);
    }

    public function verificarSemiFinal()
    {
        //Obter batalhas já geradas da final
        $batalhasFinal = Batalha::where('fase', 4)->get();
        //Quais equipes devem ser removidas da busca na semi final.
        $equipesRemove = array_unique(array_merge($batalhasFinal->pluck('equipe1_id')->toArray(), $batalhasFinal->pluck('equipe2_id')->toArray()));

        //Obter batalhas com vencedor das quartas de final.
        $batalhasVencidas = Batalha::where('equipe_vencedora_id', '!=', null)
            ->where('fase', 3)
            ->whereNotIn('equipe1_id', $equipesRemove)
            ->whereNotIn('equipe2_id', $equipesRemove)
            ->get();

        //Se houver um número par de batalhas com vencedor, pode-se gerar
        //uma batalha para a semi final.
        if (($batalhasVencidas->count() % 2) == 0) {
            $equipes = $batalhasVencidas->pluck('equipe_vencedora_id', 'equipe_vencedora_id')->toArray();

            $gerador = new BatalhaGenerator;
            $gerador->setEquipes($equipes);
            $gerador->gerarBatalhasSequencia();
            $novasBatalhas = $gerador->getBatalhas();
            with(new FaseGenerator)->salvar($novasBatalhas, 4, $batalhasFinal->count());

            //Gerar batalha com os perdedores da semi final
            $pEquipes = $batalhasVencidas->pluck('equipe_perdedora_id', 'equipe_perdedora_id')->toArray();
            $pGerador = new BatalhaGenerator;
            $pGerador->setEquipes($pEquipes);
            $pGerador->gerarBatalhaSequencia();
            with(new FaseGenerator)->salvar($pGerador->getBatalhas(), 4, ($batalhasFinal->count() + count($novasBatalhas)));
        }

        //Se todas as batalhas das quartas foram finalizadas, deve-se passar para
        //a semi final.
        $countBatalhas = Batalha::where('fase', 3)->count();
        $countConcluidas = Batalha::where('fase', 3)
            ->where('status', 'concluida')
            ->count();

        //Ir para a próxima fase.
        if ($countBatalhas == $countConcluidas) {
            $this->atualizarFase($fase = 3);
        }

        event(new UpdateChaveamentoEvent);
    }

    public function verificarFinal()
    {
        $batalhasQuery = Batalha::where('fase', 4)->sorteio();
        $batalhasConcluidas = Batalha::where(['fase' => 4, 'status' => 'concluida'])->count();

        //Se todas as batalhas foram concluidas, gera a colocação do torneio.
        if ($batalhasQuery->count() == $batalhasConcluidas) {
            $batalhas = $batalhasQuery->get();

            $colocacao = 1;
            foreach ($batalhas as $batalha)
            {
                Colocacao::create([
                    'equipe_id' => $batalha->equipe_vencedora_id,
                    'colocacao' => $colocacao++
                ]);

                Colocacao::create([
                    'equipe_id' => $batalha->equipe_perdedora_id,
                    'colocacao' => $colocacao++
                ]);
            }
        }

        event(new UpdateChaveamentoEvent);
    }

    protected function atualizarFase($faseAtual)
    {
        TorneioConfig::where('nome', 'fase_torneio')->update(['valor' => ++$faseAtual]);
    }
}