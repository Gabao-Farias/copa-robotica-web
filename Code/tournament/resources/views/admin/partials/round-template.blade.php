<div class="panel-group">
	@foreach ($batalhas as $batalha)
		<div class="panel panel-default">
			<div class="panel-heading bigger-font">
				<div class="clearfix">
					<strong>{{ $batalha->equipe1->nome }} (VS) {{ $batalha->equipe2->nome }}</strong>
				</div>
			</div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="media">
                        <div class="media-left">
                            <a href="{{ Helpers::resolverFotoRobo($batalha->equipe1) }}" target="_blank">
                                <img class="media-object foto-equipe-round" src="{{ Helpers::resolverFotoRobo($batalha->equipe1) }}" alt="FOTO">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading font-bold batalha-equipe-heading">{{ $batalha->equipe1->nome }}</h4>
                            <p>{{ $batalha->equipe1->escola->nome }}</p>
                            <p class="round-pontos bigger-font font-bold" id="{{ $batalha->equipe1->id }}" data-pontos="{{ $batalha->equipe1->pontosRound($round)->sum('pontos') }}">
                                {{ $batalha->equipe1->pontosRound($round)->sum('pontos') }} Pontos
                            </p>
                            <p class="won-rounds bigger-font font-bold" id="{{ $batalha->equipe1->id }}" style="line-height: 0;">{{ $batalha->equipe1->roundsVencidosBatalha($batalha)->count() }} Round(s)</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="clearfix">
                        <span class="batalha-versus">VS</span>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="media">
                        <div class="media-body text-right">
                            <h4 class="media-heading font-bold batalha-equipe-heading">{{ $batalha->equipe2->nome }}</h4>
                            <p>{{ $batalha->equipe2->escola->nome }}</p>
                            <p class="round-pontos bigger-font font-bold" id="{{ $batalha->equipe2->id }}" data-pontos="{{ $batalha->equipe2->pontosRound($round)->sum('pontos') }}">
                                {{ $batalha->equipe2->pontosRound($round)->sum('pontos') }} Pontos
                            </p>
                            <p class="won-rounds bigger-font font-bold" id="{{ $batalha->equipe2->id }}" style="line-height: 0;">{{ $batalha->equipe2->roundsVencidosBatalha($batalha)->count() }} Round(s)</p>
                        </div>
                        <div class="media-right">
                            <a href="{{ Helpers::resolverFotoRobo($batalha->equipe2) }}" target="_blank">
                                <img class="media-object foto-equipe-round" src="{{ Helpers::resolverFotoRobo($batalha->equipe2) }}" alt="FOTO">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	@endforeach
</div>