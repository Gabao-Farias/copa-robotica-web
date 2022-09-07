@extends('layouts.app')

@section('page-title', 'Ringues do Torneio')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-dark">
                    <div class="panel-heading">
                        Ringues do Torneio
                    </div>
                    <ul class="list-group dark">
                        @foreach ($ringues as $ringue)
                            <li class="list-group-item">
                                {{ $ringue->nome }}
                                <span class="pull-right">
                                    <button class="btn btn-sm btn-default dark assistir{{ (Request::cookie('ringue_assistindo') == $ringue->id) ? ' disabled' : '' }}" id="{{ $ringue->id }}">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        <span class="watch-text">
                                            @if (Request::cookie('ringue_assistindo') == $ringue->id)
                                                Assistindo
                                            @else
                                                Assistir
                                            @endif
                                        </span>
                                    </button>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('assets')
    <script src="{{ asset('js/RingueWatcher.js') }}"></script>
    <script>
        $(function() {
            var watcher = new RingueWatcher();

            @if (! is_null(Request::cookie('ringue_assistindo')))
                watcher.watch({{ Request::cookie('ringue_assistindo') }});
            @endif
        });
    </script>
@endsection