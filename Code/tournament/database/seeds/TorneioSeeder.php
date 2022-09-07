<?php

use App\Equipe;
use App\Escola;
use App\Integrante;
use Illuminate\Database\Seeder;

class TorneioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        include(base_path() . '/storage/sql_copa/dados.php');

        $codigo = 1;
        foreach ($dados as $dadosEscola)
        {
            $escola = Escola::create([
                'nome' => $dadosEscola['nome'],
                'cidade' => $dadosEscola['cidade']
            ]);

            if (isset($dadosEscola['equipes'])) {
                foreach ($dadosEscola['equipes'] as $dadosEquipe)
                {
                    $fotoEquipe = '/uploads/fotos/equipes/equipe_' . $codigo . '.jpg';
                    $fotoRobo = '/uploads/fotos/robos/robo_' . $codigo . '.jpg';

                    if (! file_exists(public_path() . $fotoEquipe)) {
                        $fotoEquipe = null;
                    }

                    if (! file_exists(public_path() . $fotoRobo)) {
                        $fotoRobo = null;
                    }

                    $equipe = $escola->equipes()->save(new Equipe([
                        'nome' => $dadosEquipe['nome'],
                        'presente' => $dadosEquipe['presente'],
                        'codigo' => $codigo++,
                        'foto_equipe_path' => $fotoEquipe,
                        'foto_robo_path' => $fotoRobo
                    ]));

                    foreach ($dadosEquipe['integrantes'] as $dadosIntegrante)
                    {
                        $separar = explode('|', $dadosIntegrante);
                        $nome = $separar[0];
                        $capitao = (int) $separar[1];

                        $equipe->integrantes()->save(new Integrante([
                            'nome' => $nome,
                            'capitao' => $capitao
                        ]));
                    }
                }
            }
        }
    }
}
