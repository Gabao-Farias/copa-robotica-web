<div class="panel{{ isset($darkTheme) ? ' panel-dark' : ' panel-default' }}" style="margin-top: 20px;">
    <div class="panel-heading font-bold">
        Pontos Registrados
    </div>
    <ul class="list-group{{ (isset($darkTheme) && $darkTheme) ? ' dark' : '' }}">
        @if ($pontos->count())
            @foreach ($pontos as $ponto)
                <li class="list-group-item clearfix">
                    {{ config('torneio.nomes_golpes.'.$ponto->tipo_ponto) }} @if ($ponto->pontos) (+{{ $ponto->pontos }} Pontos) @endif
                    @if (! isset($hideControls) || ! $hideControls)
                    <span class="remove-ponto pull-right text-danger" id="{{ $ponto->id }}" style="cursor: pointer;" title="Remover" data-toggle="tooltip" data-equipe-nome="{{ $equipe->nome }}" data-ataque-nome="{{ config('torneio.nomes_golpes.'.$ponto->tipo_ponto) }}">
                        <span class="glyphicon glyphicon-remove"></span>
                    </span>
                    @endif
                </li>
            @endforeach
        @else
            <li class="list-group-item list-group-item-warning alert-important">Não há pontos ainda.</li>
        @endif
    </ul>
</div>