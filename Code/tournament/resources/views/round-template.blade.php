<div class="panel-group">
	@foreach ($batalhas as $batalha)
        <div class="row">
            <div class="col-sm-5">
                <div class="media dark">
                    <div class="media-left">
                        <a href="{{ Helpers::resolverFotoRobo($batalha->equipe1) }}" target="_blank">
                            <img class="media-object foto-equipe-round" src="{{ Helpers::resolverFotoRobo($batalha->equipe1) }}" alt="FOTO">
                        </a>
                    </div>
                    <div class="media-body">
                        <div class="panel panel-dark">
                            <div class="panel-heading no-radius-left">
                                {{ $batalha->equipe1->nome }}
                            </div>
                            <div class="panel-body">
                                <p class="round-pontos" id="{{ $batalha->equipe1->id }}" data-pontos="{{ $batalha->equipe1->pontosRound($round)->sum('pontos') }}" style="margin-top: 10px;">
                                    {{ $batalha->equipe1->pontosRound($round)->sum('pontos') }} Pontos
                                </p>
                                <p class="won-rounds" id="{{ $batalha->equipe1->id }}" style="line-height: 0;">{{ $batalha->equipe1->roundsVencidosBatalha($batalha)->count() }} Round(s)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="versus-align">
                    <div class="versus-container">
                        <span class="text">
                            VS
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="media dark right">
                    <div class="media-body">
                        <div class="panel panel-dark">
                            <div class="panel-heading no-radius-left">
                                {{ $batalha->equipe2->nome }}
                            </div>
                            <div class="panel-body">
                                <p class="round-pontos" id="{{ $batalha->equipe2->id }}" data-pontos="{{ $batalha->equipe2->pontosRound($round)->sum('pontos') }}" style="margin-top: 10px;">
                                    {{ $batalha->equipe2->pontosRound($round)->sum('pontos') }} Pontos
                                </p>
                                <p class="won-rounds" id="{{ $batalha->equipe2->id }}" style="line-height: 0;">{{ $batalha->equipe2->roundsVencidosBatalha($batalha)->count() }} Round(s)</p>
                            </div>
                        </div>
                    </div>
                    <div class="media-right">
                        <a href="{{ Helpers::resolverFotoRobo($batalha->equipe2) }}" target="_blank">
                            <img class="media-object foto-equipe-round" src="{{ Helpers::resolverFotoRobo($batalha->equipe2) }}" alt="FOTO">
                        </a>
                    </div>
                </div>
            </div>
        </div>
	@endforeach
</div>