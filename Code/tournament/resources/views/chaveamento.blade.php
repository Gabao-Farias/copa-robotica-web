@extends('layouts.default')

@section('page-title', 'Chaveamento')

@section('content')
    <input type="hidden" id="chaveamento-data" value="{{ json_encode($chaveamento) }}">
    <div class="container">
        <h1 class="text-uppercase chaveamento-title">Eliminatórias - Copa URI de Robótica {{ date('Y') }}</h1>
        <div class="chaveamento"></div>
    </div>
@endsection

@section('assets')
    <link rel="stylesheet" href="{{ asset('js/jquery-bracket-master/dist/jquery.bracket.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bracket-tweaks.css') }}">
    <script src="{{ asset('js/jquery-bracket-master/dist/jquery.bracket.min.js') }}"></script>
    <script>
        $(function () {
            Echo.channel('chaveamento')
                    .listen('UpdateChaveamentoEvent', function (e) {
                        location.reload();
                    });

            $('.chaveamento').bracket(JSON.parse($('#chaveamento-data').val()));

            var hasWinners = '{{ $hasWinners }}';
            if (parseInt(hasWinners)) {
                setTimeout(function() {
                    window.location.href = '{{ url('vencedores') }}';
                }, 60000);
            }
        });
    </script>
@endsection
