<?php

namespace App\Http\Controllers;

use App\Ringue;
use Illuminate\Http\Request;

use App\Http\Requests;

class RinguesController extends Controller
{
    public function index()
    {
        $ringues = Ringue::orderBy('nome', 'asc')->get();

        return view('ringues', compact('ringues'));
    }

    public function assistir(Ringue $ringue)
    {
        $round = $ringue->roundAtivo()->first();
        return response(['ringue' => $ringue, 'round' => $round], 200)->cookie(
            'ringue_assistindo', $ringue->id, 0
        );
    }
}
