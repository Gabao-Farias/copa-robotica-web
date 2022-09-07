@extends('layouts.admin.app')

@section('page-title', 'Iniciar Batalha')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
            <div class="clearfix">
                <div class="pull-left">
                    <h1 class="font-thin">Iniciar Batalha</h1>
                </div>
                <div class="pull-right">
                    <a href="{{ url('admin/torneio/batalhas') }}" class="btn btn-primary action-button">
                        <span class="glyphicon glyphicon-arrow-left glyphicon-margin-right"></span>
                        Voltar
                    </a>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Iniciar Batalha</strong> ({{ $batalha->equipe1->nome }} VS {{ $batalha->equipe2->nome }})
                </div>
                <div class="panel-body">
                    {!! Form::open(['url' => url('admin/torneio/batalha/' . $batalha->id . '/iniciar'), 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                	   <div class="form-group">
					    	<label for="text" class="col-md-4 control-label">Equipes</label>

					    	<div class="col-md-6">
					        	<input type="text" class="form-control" value="{{ $batalha->equipe1->nome }} VS {{ $batalha->equipe2->nome }}" disabled="disabled">
					    	</div>
						</div>
						<div class="form-group{{ $errors->has('ringue_id') ? ' has-error' : '' }}">
					    	<label for="text" class="col-md-4 control-label">Ringue</label>

					    	<div class="col-md-6">
                                @if ($ringuesDisponiveis->count())
    					        	{{ Form::select('ringue_id', ["" => "Selecione..."] + $ringuesDisponiveis->pluck('nome', 'id')->toArray(), null, ['class' => 'form-control']) }}
                                    @if ($errors->has('ringue_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('ringue_id') }}</strong>
                                        </span>
                                    @endif
                                @else
                                    <p class="text-muted">Nenhum ringue disponível. Aguarde...</p>
                                @endif
					    	</div>
						</div>
						<div class="form-group text-center">
							<button type="submit" class="btn btn-primary">Iniciar Batalha</button>
						</div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection