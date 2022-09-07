<?php

namespace App\Http\Controllers\Admin;

use App\Batalha;
use App\Components\BatalhaHandler\BatalhaHandler;
use App\Equipe;
use App\Events\AttackEvent;
use App\Events\NextRoundEvent;
use App\Events\RemoverPontoEvent;
use App\PontosRound;
use App\Round;
use Carbon\Carbon;
use App\Http\Requests;
use App\Events\PlayRoundEvent;
use App\Events\PauseRoundEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $batalhaHandler;

    public function __construct(BatalhaHandler $batalhaHandler)
    {
        $this->batalhaHandler = $batalhaHandler;
    }

    public function play(Round $round)
    {
    	if ($round->status != 'parada') {
    		return response(['message' => 'Esse round não pode ser iniciado.'], 422);
    	}

    	if (is_null($round->inicio)) {
    		$round->inicio = Carbon::now();
    	}

    	if (is_null($round->batalha->inicio)) {
            $round->batalha->inicio = Carbon::now();
            $round->batalha->save();
        }

        $round->ultimo_inicio = Carbon::now();
    	$round->status = 'em_andamento';
    	$round->save();

    	event(new PlayRoundEvent($round));

        $this->batalhaHandler->verificarRound($round);

    	return response(['mensagem' => 'O round foi Reiniciado com sucesso!', 'title' => 'Round Reiniciado'], 200);
    }

    public function pause(Round $round)
    {
    	if ($round->status != 'em_andamento') {
            return response(['message' => 'Esse round não pode ser parado.', 'round' => $round], 422);
        }

        $round->tempo_restante = $this->batalhaHandler->subtraiTempo($round);
        $round->ultima_parada = Carbon::now();
        $round->status = 'parada';
        $round->save();

        event(new PauseRoundEvent($round));

        $this->batalhaHandler->verificarRound($round);

        return response(['mensagem' => 'O round foi parado com sucesso!', 'title' => 'Round Parado'], 200);
    }

    public function verificaTempo(Round $round)
    {
        $round->tempo_restante = $this->batalhaHandler->subtraiTempo($round);
        $this->batalhaHandler->verificarRound($round);
    }

    public function registrarGolpe(Round $round, Equipe $equipe, $tipo)
    {
        $ponto = $round->pontos()->save(new PontosRound([
            'equipe_id' => $equipe->id,
            'batalha_id' => $round->batalha->id,
            'tipo_ponto' => $tipo,
            'pontos' => config('torneio.golpes_pontos.'.$tipo)
        ]));

        $equipePontos = $equipe;

        //Verifica se é decisão do árbitro ou ponto decisivo.
        if (in_array($tipo, ['vitoria', 'ippon'])) {
            $this->batalhaHandler->finalizarRound($round);
        }

        event(new AttackEvent($round, $equipe, $equipePontos, $ponto));
    }

    public function irProximoRound(Round $round)
    {
        $vencedor = $this->batalhaHandler->escolherVencedorRound($round);

        $proximoRound = $this->batalhaHandler->proximoRound($round);
        if (! is_null($proximoRound)) {
            $proximoRound->status = 'parada';
            $proximoRound->save();
            event(new NextRoundEvent($round, $proximoRound, $vencedor));
        } else {
            $this->batalhaHandler->finalizarBatalha($round->batalha);
        }
    }

    public function listarPontosRound(Round $round, Equipe $equipe, Request $request)
    {
        $pontos = $equipe->pontosRound($round)
            ->latest()
            ->get();

        $darkTheme = false;
        $hideControls = false;
        if ($request->has('isClient') && $request->input('isClient') == 'true') {
            $darkTheme = true;
            $hideControls = true;
        }

        return view('historico-pontos', compact('pontos', 'equipe', 'darkTheme', 'hideControls'));
    }

    public function removerPonto($pontoId)
    {
        $ponto = PontosRound::find($pontoId);
        event(new RemoverPontoEvent($ponto->round, $ponto));
        $ponto->delete();
    }
}
