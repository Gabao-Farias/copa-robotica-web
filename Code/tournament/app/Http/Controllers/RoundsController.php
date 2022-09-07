<?php

namespace App\Http\Controllers;

use App\Round;
use Illuminate\Http\Request;

use App\Http\Requests;

class RoundsController extends Controller
{
    public function index(Round $round)
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

        return view('round', compact('round', 'batalha', 'showTimer'));
    }
}
