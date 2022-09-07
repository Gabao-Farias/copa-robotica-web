<?php

namespace App\Http\Controllers\Admin;

use App\Components\BatalhaGenerator\FaseGenerator;
use App\Batalha;
use App\Components\Ranking\Ranking;
use App\Http\Requests;
use App\TorneioConfig;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TorneioController extends Controller
{
    public function index()
    {
        return view('admin.torneio.iniciar');
    }

    /**
     * Inicia o torneio e gera as batalhas da primeira fase.
     * 
     * @return \Illuminate\Http\Response
     */
    public function iniciar()
    {
        with(new FaseGenerator)->gerarPrimeiraFase();
        with(new Ranking)->atualizar();
        flash()->success('Torneio iniciado com sucesso!');

        return redirect(url('admin/torneio/batalhas'));
    }

    public function batalhas(Request $request)
    {
        $faseTorneio = (int) TorneioConfig::where('nome', 'fase_torneio')->first()->valor;
        $statusBatalhas = "";

        $batalhas = Batalha::status()->sorteio();

        if ($request->has('status_batalhas')) {
            $status = $request->input('status_batalhas');
            if (! is_null($status)) {
                $batalhas->where('status', $status);
                $statusBatalhas = $status;
            }
        }

        if ($request->exists('fase_torneio')) {
            $fase = $request->input('fase_torneio');

            if (! empty($fase)) {
                $faseTorneio = $fase;
            } else {
                $faseTorneio = "";
            }
        }

        if (! empty($faseTorneio)) {
            $batalhas->where('fase', $faseTorneio);
        }

        $batalhas = $batalhas->get();

        $total = $batalhas->count();
        $metade = ceil($total / 2);
        $batalhas1 = $batalhas->take($metade);
        $take = ($total % 2 == 0) ? -$metade : -($metade - 1);
        $batalhas2 = $batalhas->take($take);

        return view('admin.torneio.batalhas', compact('batalhas1', 'batalhas2', 'faseTorneio', 'statusBatalhas'));
    }
}
