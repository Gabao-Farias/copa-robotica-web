@extends('layouts.app')

@section('page-title', 'Batalha: ' . $batalha->equipe1->nome . ' VS ' . $batalha->equipe2->nome)

@section('content')
    <div class="row less-gutter">
        <div class="col-sm-12">
            @include('round-template', ['batalhas' => [$batalha]])

            <input type="hidden" id="round_data" value="{{ $round }}">
            <div class="row">
                <div class="col-xs-4">
                    <div class="pontos-container" id="{{ $batalha->equipe1->id }}">
                        @include('historico-pontos', [
                            'pontos' => $batalha->equipe1
                                ->pontosRound($round)
                                ->latest()
                                ->get(),
                            'equipe' => $batalha->equipe1,
                            'darkTheme' => true,
                            'hideControls' => true
                        ])
                    </div>
                </div>
                <div class="col-xs-4">
                    <h2 class="round-status-title">Round {{ $round->ordem }} <span class="round-status">({{ Helpers::resolverStatusRound($round->status) }})</span></h2>
                    <div class="partida-timer" data-time="{{ $round->tempo_restante }}" @if (! $showTimer) style="display: none;" @endif>
                        {{ gmdate('i:s', $round->tempo_restante) }}
                    </div>
                    <div class="partida-message" @if ($showTimer) style="display: none;" @endif>
                        Aguardando Árbitro
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="pontos-container" id="{{ $batalha->equipe2->id }}">
                        @include('historico-pontos', [
                            'pontos' => $batalha->equipe2
                                ->pontosRound($round)
                                ->latest()
                                ->get(),
                            'equipe' => $batalha->equipe2,
                            'darkTheme' => true,
                            'hideControls' => true
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('assets')
	<script src="{{ asset('js/RoundApi.js') }}"></script>
	<script src="{{ asset('js/Round.js') }}"></script>
	<script>
		$(function() {
			new Round($('#round_data').val(), true);
		});
	</script>
@endsection