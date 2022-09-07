@extends('layouts.default')

@section('page-title', 'Ranking Primeira Fase')

@section('content')
	<div class="wrapper-md">
		<h1 class="text-uppercase round-status-title" style="margin: 0;">Ranking Primeira Fase - Copa URI de Robótica {{ date('Y') }}</h1>
		<div class="row less-gutter">
			<div class="col-sm-6">
				<div class="panel panel-dark">
					@include('rankings-list', ['rankings' => $rankings1, 'counter' => $counter1, 'darkTheme' => true])
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-dark">
					@include('rankings-list', ['rankings' => $rankings2, 'counter' => $counter2, 'darkTheme' => true])
				</div>
			</div>
		</div>
	</div>
@endsection

@section('assets')
    <script>
        $(function () {
            var faseTorneio = '{{ $faseTorneio }}';
            Echo.channel('ranking')
                    .listen('RankUpdatedEvent', function (e) {
                        location.reload();
                    });

			$('body').css('overflow', 'hidden');

            if (parseInt(faseTorneio) > 1) {
                setTimeout(function() {
                    window.location.href = '{{ url('chaveamento') }}';
                }, 120000);
            }
        });
    </script>
@endsection
