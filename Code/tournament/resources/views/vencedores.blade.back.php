@extends('layouts.default')

@section('page-title', 'Vencedores do Torneio')

@section('content')
    <h1 class="text-uppercase vencedores-title">Vencedores do Torneio - Copa URI de Robótica {{ date('Y') }}</h1>

    <div class="row less-gutter">
        <div class="col-sm-4 text-center">
            <img src="{{ Helpers::resolverFotoEquipe($colocacao[1]->equipe) }}" alt="" class="img-vencedor img-second">
            <h3 class="winners second">2º Lugar<br> {{ $colocacao[1]->equipe->nome }}</h3>
        </div>
        <div class="col-sm-4 text-center">
            <img src="{{ Helpers::resolverFotoEquipe($colocacao[0]->equipe) }}" alt="" class="img-vencedor img-first">
            <h3 class="winners first">1º Lugar<br> {{ $colocacao[0]->equipe->nome }}</h3>
        </div>
        <div class="col-sm-4 text-center">
            <img src="{{ Helpers::resolverFotoEquipe($colocacao[2]->equipe) }}" alt="" class="img-vencedor img-third">
            <h3 class="winners third">3º Lugar<br> {{ $colocacao[2]->equipe->nome }}</h3>
        </div>
    </div>
@endsection