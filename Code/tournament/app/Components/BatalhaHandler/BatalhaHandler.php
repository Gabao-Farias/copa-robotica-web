<?php

namespace App\Components\BatalhaHandler;

use App\Batalha;
use App\Components\BatalhaGenerator\FaseGenerator;
use App\Components\BatalhaGenerator\FaseHandler;
use App\Components\Ranking\Ranking;
use App\Events\EndBatalhaEvent;
use App\Events\EndRoundEvent;
use App\Round;
use App\TorneioConfig;
use Carbon\Carbon;

class BatalhaHandler
{
    public function subtraiTempo(Round $round)
    {
        $tempo = with(new Carbon($round->ultimo_inicio))->diffInSeconds(Carbon::now());

        return max($round->tempo_restante - $tempo, 0);
    }

    public function verificarRound(Round $round)
    {
        if ($round->tempo_restante <= 0) {
            $this->finalizarRound($round);
        }
    }

    public function finalizarRound(Round $round)
    {
        $round->status = 'concluida';
        $round->fim = Carbon::now();

        $round->save();

        event(new EndRoundEvent($round));
    }

    public function proximoRound(Round $round)
    {
        $batalha = $round->batalha;
        $queryRounds = $batalha->rounds()->where('status', 'nao_iniciada');

        if ($queryRounds->count()) {
            return $queryRounds->first();
        }

        //Se houve empate, cria o 3º round.
        if ($round->ordem == 2) {
            $equipe1 = $batalha->equipe1;
            $equipe2 = $batalha->equipe2;
            $vitoriasEquipe1 = $equipe1->roundsVencidosBatalha($batalha)->count();
            $vitoriasEquipe2 = $equipe2->roundsVencidosBatalha($batalha)->count();

            if (($vitoriasEquipe1 < 2) && ($vitoriasEquipe2 < 2)) {
                return $batalha->rounds()->save(new Round(['status' => 'nao_iniciada', 'ordem' => 3, 'ringue_id' => $round->ringue_id, 'tempo_restante' => config('torneio.duracao_round')]));
            }
        }

        return null;
    }

    public function escolherVencedorRound(Round $round)
    {
        $vencedor = null;
        $batalha = $round->batalha;
        $equipe1 = $batalha->equipe1;
        $equipe2 = $batalha->equipe2;

        $pontosEquipe1 = (int) $equipe1->pontosRound($round)->sum('pontos');
        $pontosEquipe2 = (int) $equipe2->pontosRound($round)->sum('pontos');

        $golpeVitoriaRound = $round->pontos()->whereIn('tipo_ponto', ['vitoria', 'ippon'])->latest()->first();

        if (! is_null($golpeVitoriaRound)) {
            if ($golpeVitoriaRound->equipe_id == $equipe1->id) {
                $vencedor = $equipe1;
            } else if ($golpeVitoriaRound->equipe_id == $equipe2->id) {
                $vencedor = $equipe2;
            }
        } else {
            if ($pontosEquipe1 > $pontosEquipe2) {
                $vencedor = $equipe1;
            } else if ($pontosEquipe2 > $pontosEquipe1) {
                $vencedor = $equipe2;
            }
        }

        $round->equipe_vencedora_id = (! is_null($vencedor)) ? $vencedor->id : null;
        $round->save();

        return $vencedor;
    }

    public function escolheVencedorBatalha(Batalha $batalha)
    {
        $vitorias1 = $batalha->equipe1->roundsVencidosBatalha($batalha)->count();
        $vitorias2 = $batalha->equipe2->roundsVencidosBatalha($batalha)->count();

        if ($vitorias1 > $vitorias2) {
            return $batalha->equipe1;
        } else if ($vitorias2 > $vitorias1) {
            return $batalha->equipe2;
        }

        return null;
    }

    public function finalizarBatalha(Batalha $batalha)
    {
        $vencedorBatalha = $this->escolheVencedorBatalha($batalha);
        $faseTorneio = (int) TorneioConfig::where('nome', 'fase_torneio')->first()->valor;
        $vencedorSorteado = false;

        //Escolher aleatoriamente o vencedor a partir das fases mata-mata.
        if ($faseTorneio > 1 && $vencedorBatalha == null) {
            $equipes = [$batalha->equipe1, $batalha->equipe2];
            $key = array_rand($equipes);
            $vencedorBatalha = $equipes[$key];
            $vencedorSorteado = true;
        }

        if ($vencedorBatalha != null) {
            $vencedor = $vencedorBatalha->id;
            $perdedor = ($vencedorBatalha->id == $batalha->equipe1->id) ? $batalha->equipe2->id : $batalha->equipe1->id;
        } else {
            $perdedor = null;
            $vencedor = null;
        }

        $batalha->equipe_vencedora_id = $vencedor;
        $batalha->equipe_perdedora_id = $perdedor;
        $batalha->status = 'concluida';
        $batalha->vencedor_sorteado = $vencedorSorteado;
        $batalha->fim = Carbon::now();

        $batalha->save();

        //Verificar fase do torneio.
        with(new FaseHandler)->verificarFase();

        event(new EndBatalhaEvent($batalha, $vencedorBatalha, $vencedorSorteado));
    }
}