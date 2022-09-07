@if ($rankings->count())
    <table class="table table-striped{{ (isset($darkTheme) && $darkTheme) ? ' dark' : '' }}">
        <tr>
            <th class="text-center"><strong>#</strong></th>
            <th>Equipe</th>
            <th>V</th>
            <th>Ippon</th>
            <th>Pontos</th>
        </tr>
        @foreach ($rankings as $ranking)
            <tr{!! ($counter <= 8) ? ' class="highlight"' : '' !!}>
                <td class="text-center"><strong>{{ $counter++ }}</strong></td>
                <td>{{ $ranking->equipe->nome }}</td>
                <td>{{ $ranking->vitorias }}</td>
                <td>{{ $ranking->ippons }}</td>
                <td>{{ $ranking->pontos }}</td>
            </tr>
        @endforeach
    </table>
@else
    <div class="alert dark alert-warning panel-alert alert-important">
        Não há dados disponíveis no momento.
    </div>
@endif