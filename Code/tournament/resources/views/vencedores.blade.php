@extends('layouts.default')

@section('page-title', 'Vencedores')

@section('content')
    <!-- Carousel
        ================================================== -->
    <div id="vencedores" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#vencedores" data-slide-to="0" class="active"></li>
            <li data-target="#vencedores" data-slide-to="1"></li>
            <li data-target="#vencedores" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img class="fill" src="{{ Helpers::resolverFotoEquipe($colocacao[0]->equipe) }}" alt="First slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1 class="winner-first">1º LUGAR</h1>
                        <p class="winner-first">{{ $colocacao[0]->equipe->nome }}</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="fill" src="{{ Helpers::resolverFotoEquipe($colocacao[1]->equipe) }}" alt="Second slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1 class="winner-second">2º LUGAR</h1>
                        <p class="winner-second">{{ $colocacao[1]->equipe->nome }}</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="fill" src="{{ Helpers::resolverFotoEquipe($colocacao[2]->equipe) }}" alt="Third slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1 class="winner-third">3º LUGAR</h1>
                        <p class="winner-third">{{ $colocacao[2]->equipe->nome }}</p>
                    </div>
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#vencedores" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#vencedores" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div><!-- /.carousel -->
@endsection

@section('assets')
    <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">

    <script>
        $(function () {
            $('#vencedores').carousel({
                interval: 5000
            });
        });
    </script>
@endsection