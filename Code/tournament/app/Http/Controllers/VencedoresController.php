<?php

namespace App\Http\Controllers;

use App\Colocacao;
use Illuminate\Http\Request;

use App\Http\Requests;

class VencedoresController extends Controller
{
    public function index()
    {
        $colocacao = Colocacao::with('equipe')
            ->orderBy('colocacao', 'asc')
            ->limit(3)
            ->get();

        return view('vencedores', compact('colocacao'));
    }
}
