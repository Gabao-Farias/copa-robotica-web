<div class="panel-group">
    @foreach ($batalhas as $batalha)
        <div class="row batalha">
            <div class="col-sm-5">
                <div class="panel panel-dark">
                    <div class="panel-heading">
                        {{ $batalha->equipe1->nome }}
                    </div>
                    <a href="{{ Helpers::resolverFotoEquipe($batalha->equipe1) }}" target="_blank">
                        <img class="media-object foto-equipe-round" src="{{ Helpers::resolverFotoEquipe($batalha->equipe1) }}" alt="FOTO">
                    </a>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="versus-align">
                    <div class="versus-container">
                        <span class="text">
                            VS
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="panel panel-dark">
                    <div class="panel-heading">
                        {{ $batalha->equipe2->nome }}
                    </div>
                    <a href="{{ Helpers::resolverFotoEquipe($batalha->equipe2) }}" target="_blank">
                        <img class="media-object foto-equipe-round" src="{{ Helpers::resolverFotoEquipe($batalha->equipe2) }}" alt="FOTO">
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>