@extends('layouts.admin.app')

@section('page-title', 'Batalhas do Torneio')

@section('content')
<div class="wrapper-md">
	<h1 class="font-bold">Batalhas do Torneio</h1>
    <div class="row no-gutter" style="margin-bottom: 5px;">
        <div class="col-sm-6">
            {{ Form::open(['url' => url('admin/torneio/batalhas'), 'method' => 'GET', 'class' => 'form-inline busca-batalha']) }}
                <div class="form-group">
                    <label for="fase-torneio">Fase do Torneio:</label>
                    {{ Form::select('fase_torneio', ["" => "Todas"] + config('torneio.fases_torneio'), $faseTorneio, ['class' => 'form-control', 'id' => 'fase-torneio']) }}
                </div>

                <div class="form-group">
                    <label for="status-batalha">Status da Batalha:</label>
                    {{ Form::select('status_batalhas', ["" => "Todos"] + config('torneio.status_batalha'), $statusBatalhas, ['class' => 'form-control', 'id' => 'status-batalha']) }}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">
                        Buscar
                    </button>
                </div>
                <div class="form-group">
                    <a href="{{ url('admin/torneio/batalhas') }}" title="Desfazer Busca" class="text-danger" data-toggle="tooltip" style="margin-left: 10px;">
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>
                </div>
            {{ Form::close() }}
        </div>
        <div class="col-sm-4">
            <strong>{{ $batalhas1->count() + $batalhas2->count() }} batalhas encontradas.</strong>
        </div>
    </div>
	@if ($batalhas1->count())
		<div class="row less-gutter">
		    <div class="col-md-6">
		        @include('admin.partials.batalha-template', ['batalhas' => $batalhas1, 'view_only' => false])
		    </div>
		    <div class="col-md-6">
		        @include('admin.partials.batalha-template', ['batalhas' => $batalhas2, 'view_only' => false])
		    </div>
		</div>
	@else
		<div class="alert alert-warning alert-panel alert-important">
			Não há dados disponíveis no momento.
		</div>
	@endif
</div>
@endsection

@section('assets')

@endsection