@extends('layouts.admin.app')

@section('page-title', 'Torneio e Batalhas')

@section('content')
<div class="container text-center">
    <h1 class="text-uppercase font-bold">Iniciar Torneio</h1>
    <a href="#" class="btn btn-primary btn-lg action-button iniciar-torneio">
        <span class="glyphicon glyphicon-play-circle glyphicon-margin-right"></span>
        Iniciar Torneio
    </a>
</div>
@endsection

@section('assets')
    <script>
        $(function () {
            $('.iniciar-torneio').click(function () {
                Alerter.confirm('Tem certeza que deseja iniciar um novo torneio? <strong>Todas as batalhas serão apagadas e geradas novamente.</strong>', 'Iniciar o Torneio', function () {
                    window.location.href = '{{ url('admin/torneio/iniciar') }}';
                });
            })
        });
    </script>
@endsection