<?php

namespace App\Components\Ranking;

use App\Equipe;
use App\Events\RankUpdatedEvent;
use App\Ranking as RankingModel;
use App\TorneioConfig;

class Ranking
{
    public function resetar()
    {
        RankingModel::truncate();
    }

    public function atualizar($broadcast = true)
    {
        $this->resetar();

        $equipes = Equipe::where('presente', 1)->get();

        foreach ($equipes as $equipe) {
            $equipe->vitorias = 0;
            $equipe->ippons = 0;
            $equipe->totalPontos = 0;

            $batalhas = $equipe->batalhas->filter(function ($batalha) {
                return $batalha->fase == 1;
            });

            $batalhas = $batalhas->sortByDesc(function ($batalha) use ($equipe) {
                if ($batalha->equipe_vencedora_id == $equipe->id) {
                    $equipe->vitorias++;
                }

                return ($batalha->equipe_vencedora_id == $equipe->id);
            })
                ->sortByDesc(function ($batalha) use ($equipe) {
                    $ippons = $batalha->pontos()->where('equipe_id', $equipe->id)
                        ->where('tipo_ponto', 'ippon')->count();

                    $equipe->ippons += $ippons;

                    return $ippons;
                })
                ->sortByDesc(function ($batalha) use ($equipe) {
                    $pontos = $batalha->pontos()->where('equipe_id', $equipe->id)
                        ->sum('pontos');

                    $equipe->totalPontos += $pontos;

                    return $pontos;
                });

            //Remover pior resultados se jogou mais que máximo de batalhas.
            if ($batalhas->count() > config('torneio.equipe_max_batalhas')) {
                $ultimo = $batalhas->last();

                if ($ultimo->equipe_vencedora_id == $equipe->id) {
                    $equipe->vitorias--;
                }

                $ipponsUltimo = $ultimo->pontos()->where('equipe_id', $equipe->id)
                    ->where('tipo_ponto', 'ippon')->count();
                $equipe->ippons -= $ipponsUltimo;

                $pontosUltimo = $ultimo->pontos()->where('equipe_id', $equipe->id)
                    ->sum('pontos');
                $equipe->totalPontos -= $pontosUltimo;
            }

            RankingModel::create([
                'equipe_id' => $equipe->id,
                'vitorias' => $equipe->vitorias,
                'ippons' => $equipe->ippons,
                'pontos' => $equipe->totalPontos
            ]);
        }

        if ($broadcast) {
            event(new RankUpdatedEvent());
        }
    }

    public function listar($limit = true)
    {
        $query = RankingModel::join('equipes as eq', 'eq.id', '=', 'rankings.equipe_id')
            ->whereRaw('(rankings.vitorias > 0 or rankings.ippons > 0 or rankings.pontos > 0)')
            ->orderBy('rankings.vitorias', 'desc')
            ->orderBy('rankings.ippons', 'desc')
            ->orderBy('rankings.pontos', 'desc');

            $query->orderBy('eq.nome', 'asc');

        if ($limit) {
            $query->limit(config('torneio.equipes_por_fase.1'));
        }

        return $query->get();
    }

    public function listarSemRestricao($limit = true)
    {
        $query = RankingModel::join('equipes as eq', 'eq.id', '=', 'rankings.equipe_id')
            ->orderBy('rankings.vitorias', 'desc')
            ->orderBy('rankings.ippons', 'desc')
            ->orderBy('rankings.pontos', 'desc')
            ->orderBy('eq.nome', 'asc');

        if ($limit) {
            $query->limit(config('torneio.equipes_por_fase.1'));
        }

        return $query->get();
    }
}
