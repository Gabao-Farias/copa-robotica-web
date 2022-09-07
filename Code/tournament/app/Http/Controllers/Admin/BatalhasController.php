<?php

namespace App\Http\Controllers\Admin;

use App\Components\BatalhaHandler\BatalhaHandler;
use App\Events\RingueRoundEvent;
use App\Round;
use App\Ringue;
use App\Batalha;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IniciarBatalhaRequest;

class BatalhasController extends Controller
{
    public function iniciar(Batalha $batalha)
    {
        $nomeBatalha = $batalha->equipe1->nome . ' VS ' . $batalha->equipe2->nome;
        
        if ($batalha->status != "nao_iniciada") {
            flash()->error("A batalha <strong>{$nomeBatalha}</strong> já foi iniciada por outro mesário.")->important();
            
            return redirect(url('admin/torneio/batalhas'));
        }

        $ringuesDisponiveis = Ringue::disponivel()->get();

    	return view('admin.batalhas.iniciar', compact('batalha', 'ringuesDisponiveis'));
    }

    public function doIniciar(Batalha $batalha, IniciarBatalhaRequest $request)
    {
    	$nomeBatalha = $batalha->equipe1->nome . ' VS ' . $batalha->equipe2->nome;

    	//Verificar se alguém já não iniciou esssa batalha.
    	if ($batalha->status != "nao_iniciada") {
    		flash()->error("A batalha <strong>{$nomeBatalha}</strong> já foi iniciada por outro mesário.")->important();
    		
    		return redirect(url('admin/torneio/batalhas'));
    	}

        $ringue = Ringue::disponivel()->where('id', $request->input('ringue_id'))->first();

        //Verificar se o ringue escolhido está disponível.
        if (is_null($ringue)) {
            flash()->error("O ringue informado não está mais disponível. Tente novamente.")->important();

            return redirect()->back()->withInput();
        }

        $save = $batalha->rounds()->saveMany([
            new Round(['status' => 'parada', 'ordem' => 1, 'ringue_id' => $ringue->id, 'tempo_restante' => config('torneio.duracao_round')]),
            new Round(['status' => 'nao_iniciada', 'ordem' => 2, 'ringue_id' => $ringue->id, 'tempo_restante' => config('torneio.duracao_round')])
        ]);

        $batalha->status = 'em_andamento';
        $batalha->save();

        event(new RingueRoundEvent($ringue, $save[0]));

        return redirect(url('admin/torneio/round/' . $save[0]->id));
    }

    public function batalhaRound(Round $round)
    {
        $batalha = $round->batalha;

        $showTimer = true;

        switch ($round->status) {
            default:
            case 'em_andamento':
                $controlIcon = 'glyphicon-pause';
                $controlValue = 1;
            break;
            case 'parada':
                $controlIcon = 'glyphicon-play';
                $controlValue = 0;
            break;
            case 'concluida':
                $controlIcon = 'glyphicon-forward';
                $controlValue = 2;
                $showTimer = false;
            break;
        }

        return view('admin.batalhas.batalha',
            compact('batalha', 'round', 'controlIcon', 'controlValue', 'showTimer')
        );
    }
}
