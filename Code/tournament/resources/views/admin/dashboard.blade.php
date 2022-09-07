@extends('layouts.admin.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading font-bold">Bem vindo!</div>

                <div class="panel-body">
                    Você está autenticado! Use o menu acima para navegar.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
