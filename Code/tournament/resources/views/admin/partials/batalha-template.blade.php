<div class="panel-group">
	@foreach ($batalhas as $batalha)
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="clearfix">
					<strong>{{ $batalha->equipe1->nome }} (VS) {{ $batalha->equipe2->nome }}</strong> ({{ Helpers::resolverStatusBatalha($batalha->status) }})
					@if ((! isset($view_only) || ! $view_only))
                        <div class="pull-right">
                        	@if ($batalha->status == 'em_andamento')
                        		@if ($batalha->rounds()->ordem()->ativo()->count())
	                        		<a href="{{ url('admin/torneio/round/' . $batalha->rounds()->ordem()->ativo()->first()->id) }}" class="btn btn-sm btn-default">
	                            		Continuar Batalha
	                            	</a>
                            	@else
                            		<a href="{{ url('admin/torneio/round/' . $batalha->rounds()->ordem()->concluido()->first()->id) }}" class="btn btn-sm btn-default">
	                            		Continuar Batalha
	                            	</a>
                            	@endif
                            @elseif ($batalha->status == 'nao_iniciada')
	                            <a href="{{ url('admin/torneio/batalha/' . $batalha->id . '/iniciar') }}" class="btn btn-sm btn-default">
	                            	Iniciar Batalha
	                            </a>
                            @endif
                        </div>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-sm-5">
					<div class="media">
						<div class="media-left">
							<a href="{{ Helpers::resolverFotoRobo($batalha->equipe1) }}" target="_blank">
								<img class="media-object foto-equipe-batalha-generator" src="{{ Helpers::resolverFotoRobo($batalha->equipe1) }}" alt="FOTO">
							</a>
						</div>
						<div class="media-body">
							<p class="media-heading font-bold batalha-equipe-heading">
								@if ($batalha->equipe_vencedora_id == $batalha->equipe1->id)
                                    <span class="glyphicon glyphicon-star text-warning" title="Vencedor" data-toggle="tooltip" style="cursor: pointer;"></span>
                                @endif
                                {{ $batalha->equipe1->nome }}
							</p>
							<p>{{ $batalha->equipe1->escola->nome }}</p>
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
							<p class="media-heading font-bold batalha-equipe-heading">
                                @if ($batalha->equipe_vencedora_id == $batalha->equipe2->id)
                                    <span class="glyphicon glyphicon-star text-warning" title="Vencedor" data-toggle="tooltip" style="cursor: pointer;"></span>
                                @endif
                                {{ $batalha->equipe2->nome }}
                            </p>
							<p>{{ $batalha->equipe2->escola->nome }}</p>
						</div>
						<div class="media-right">
							<a href="{{ Helpers::resolverFotoRobo($batalha->equipe2) }}" target="_blank">
								<img class="media-object foto-equipe-batalha-generator" src="{{ Helpers::resolverFotoRobo($batalha->equipe2) }}" alt="FOTO">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach
</div>