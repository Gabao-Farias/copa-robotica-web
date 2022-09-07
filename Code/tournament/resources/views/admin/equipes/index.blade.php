@extends('layouts.admin.app')

@section('page-title', 'Equipes Cadastradas')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                <div class="clearfix">
                    <div class="pull-left">
                        <h1 class="font-thin">Equipes Cadastradas</h1>
                    </div>
                    <div class="pull-right">
                        <a href="{{ url('admin/equipes/cadastrar') }}" class="btn btn-primary action-button">
                            <span class="glyphicon glyphicon-plus-sign glyphicon-margin-right"></span>
                            Cadastrar Equipe
                        </a>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-6 col-sm-offset-6">
                        {{ Form::open(['url' => url('admin/equipes/buscar'), 'class' => 'busca-equipe']) }}
                        <div class="input-group">
                            <span class="input-group-addon clickable desfazer-busca" style="color: #7788FF;" title="Desfazer Busca" data-toggle="tooltip">
                                <span class="glyphicon glyphicon-remove"></span>
                            </span>
                            <input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar equipe por nome, escola ou integrante..." value="{{ isset($busca) ? $busca : '' }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
                @if ($equipes->count())
                    <div class="panel-group">
                        @foreach ($equipes as $equipe)
                            <div class="panel panel-default">
                                <div class="panel-heading clearfix">
                                    <strong>{{ $equipe->nome }}</strong>

                                    <div class="pull-right">
                                        <div class="btn-group">
                                            <a href="{{ url('admin/equipes/editar/' . $equipe->id) }}" class="btn btn-sm btn-default">Editar</a>
                                            <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" class="excluir-equipe" id="{{ $equipe->id }}" data-nome="{{ $equipe->nome }}">Excluir</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="media no-margin">
                                    <div class="media-left">
                                        <a href="#">
                                          <img class="media-object foto-equipe" src="{{ Helpers::resolverFotoRobo($equipe) }}" alt="Foto">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading heading-equipe" style="font-weight: 600;">{{ $equipe->nome }}</h4>
                                        <p>{{ $equipe->escola->nome }} - {{ $equipe->escola->cidade }}</p>
                                        <hr class="integrantes-separator">
                                        <strong>Integrantes</strong><br>
                                        <div class="clearfix" style="margin-bottom: 10px;">
                                            @foreach ($equipe->integrantes as $integrante)
                                                <span class="glyphicon glyphicon-user" title="{{ $integrante->nome }}{{ $integrante->capitao ? ' (Capitão)' : '' }}" data-toggle="tooltip" style="float: left; margin-left: 5px; cursor: pointer; font-size: 16px;{{ $integrante->capitao ? ' color: #48a2f1;' : '' }}"></span>
                                            @endforeach
                                        </div>
                                        <p><strong>Presente?</strong> {{ $equipe->presente ? 'Sim' : 'Não' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if (! empty(trim($links)))
                    <div class="panel panel-default">
                        <div class="panel-footer">
                            <div class="hbox">
                                <div class="pull-left" style="margin: 8px 20px 0 0;">
                                    Páginas de Equipes
                                </div>
                                <div class="pull-left">
                                    {{ $links }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @else
                    <div class="alert alert-warning panel-alert alert-important">
                        @if (isset($busca))
                            Sua busca não retornou resultados.
                        @else
                            Ainda não há equipes cadastradas. <a href="{{ url('admin/equipes/cadastrar') }}">Cadastrar equipe</a>.
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('assets')
<script>
    $(function() {
        $('.excluir-equipe').click(function() {
            var id = $(this).attr('id'),
                nome = $(this).data('nome');
            if (confirm('Tem certeza que deseja excluir a equipe "' + nome + '"?')) {
                window.location.href = '{{ url('admin/equipes/deletar') }}' + '/' + id;
            }
        });

        $('.busca-equipe').on('submit', function(e) {
            e.preventDefault();

            var url = $(this).attr('action'),
                busca = $(this).find('#busca').val().trim();

            if (busca != "") {
                window.location.href = url + '/' + encodeURI(busca);
            }
        });

        $('.desfazer-busca').click(function() {
            window.location.href = '{{ url('admin/equipes') }}';
        });
    });
</script>
@endsection