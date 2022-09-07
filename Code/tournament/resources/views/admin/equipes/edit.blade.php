@extends('layouts.admin.app')

@section('page-title', 'Editar Equipe "' . $equipe->nome . '"')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                <div class="clearfix">
                    <div class="pull-left">
                        <h1 class="font-thin">Editar Equipe</h1>
                    </div>
                    <div class="pull-right">
                        <a href="{{ url('admin/equipes') }}" class="btn btn-primary action-button">
                            <span class="glyphicon glyphicon-arrow-left glyphicon-margin-right"></span>
                            Voltar
                        </a>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Editar Equipe "{{ $equipe->nome }}"
                    </div>
                    <div class="panel-body">
                        {!! Form::model($equipe, ['url' => url('admin/equipes/editar/' . $equipe->id), 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                    	   @include('admin.equipes.form', ['button' => 'Editar', 'mode' => 'edit'])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('assets')
    <script src="{{ asset('js/file-upload/compiled.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('js/file-upload/css/jquery.fileupload.css') }}">
    @include('admin.equipes.equipes-assets')
@endsection