<?php
Route::get('/', function () {
    return view('welcome');
});

Route::get('ringues', 'RinguesController@index');
Route::get('assistir-ringue/{ringue}', 'RinguesController@assistir');
Route::get('round/{round}', 'RoundsController@index');

Route::get('round/api/listar-pontos/{round}/{equipe}', 'Admin\ApiController@listarPontosRound');

Route::get('ranking', 'RankingController@index');
Route::get('chaveamento', 'ChaveamentoController@index');

Route::get('vencedores', 'VencedoresController@index');

Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {
    Route::get('/', 'AdminController@index');
    Route::get('view-batalhas', function () {
        $equipes = \App\Equipe::latest()->get();

        foreach ($equipes as $equipe) {
            echo $equipe->nome . ' possui ' . $equipe->batalhas->count() . ' batalhas<br>';
        }
    });

    //Rotas para equipes
    Route::get('equipes', 'EquipesController@index');
    Route::get('equipes/buscar/{busca}', 'EquipesController@buscar');
    Route::get('equipes/cadastrar', 'EquipesController@create');
    Route::post('equipes/cadastrar', 'EquipesController@store');
    Route::get('equipes/deletar/{equipe}', 'EquipesController@delete');
    Route::get('equipes/editar/{equipe}', 'EquipesController@edit');
    Route::post('equipes/editar/{equipe}', 'EquipesController@update');
    //Upload foto
    Route::post('upload-foto/{type}', 'UploadFotoController@upload');

    //Torneio e Batalhas
    Route::get('torneio', 'TorneioController@index');
    Route::get('torneio/iniciar', 'TorneioController@iniciar');
    Route::get('torneio/batalhas', 'TorneioController@batalhas');

    //Batalhas
    Route::get('torneio/batalha/{batalha}/iniciar', 'BatalhasController@iniciar');
    Route::post('torneio/batalha/{batalha}/iniciar', 'BatalhasController@doIniciar');
    Route::get('torneio/round/{round}', 'BatalhasController@batalhaRound');

    //API dos Rounds
    Route::group(['prefix' => 'round/api'], function() {
        Route::get('play/{round}', 'ApiController@play');
        Route::get('pause/{round}', 'ApiController@pause');
        Route::get('check-status/{round}', 'ApiController@verificaTempo');
        Route::get('registrar-golpe/{round}/{equipe}/{golpe}', 'ApiController@registrarGolpe');
        Route::get('proximo-round/{round}', 'ApiController@irProximoRound');
        Route::get('finalizar-batalha/{batalha}', 'ApiController@finalizarBatalha');
        Route::get('remover-ponto/{ponto}', 'ApiController@removerPonto');
    });


    //Verificações rapidas
    Route::get('verificar-batalhas', function() {
        $return = '<strong>*Somente equipes presentes no torneio:</strong><br><br>';
        foreach (App\Equipe::where('presente', 1)->get() as $equipe)
        {
            $return .= 'A equipe ' . $equipe->nome . ' possui ' . $equipe->batalhas()->count() . ' batalhas<br><br>';
        }
        return $return;
    });

    Route::get('codigos', function() {
        $return = '';
        foreach (App\Equipe::get() as $equipe)
        {
            $return .= 'Código: ' . $equipe->codigo . ' | Equipe: ' . $equipe->nome . ' | Escola: ' . $equipe->escola->nome . '<br><br>';
        }

        return $return;
    });

    Route:get('carregar-fotos', function () {
        $equipes = App\Equipe::get();

        foreach ($equipes as $equipe)
        {
            $codigo = $equipe->codigo;

            $fotoEquipe = '/uploads/fotos/equipes/equipe_' . $codigo . '.jpg';
            $fotoRobo = '/uploads/fotos/robos/robo_' . $codigo . '.jpg';

            if (! file_exists(public_path() . $fotoEquipe)) {
                $fotoEquipe = null;
            }

            if (! file_exists(public_path() . $fotoRobo)) {
                $fotoRobo = null;
            }

            $equipe->foto_equipe_path = $fotoEquipe;
            $equipe->foto_robo_path = $fotoRobo;

            $equipe->save();
        }
    });
});
