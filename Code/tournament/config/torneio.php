<?php

return [
	//Duração de um round em segundos.
	'duracao_round' => 90,
    //Máximo de batalhas para uma equipe.
    'equipe_max_batalhas' => 3,

	'status_batalha' => [
		'nao_iniciada' => 'Não Iniciada',
		'em_andamento' => 'Em Andamento',
		'concluida' => 'Concluída'
	],

	'status_round' => [
		'nao_iniciada' => 'Não Iniciado',
		'em_andamento' => 'Em Andamento',
		'parada' => 'Parado',
		'concluida' => 'Concluído'
	],

    'nomes_golpes' => [
        'vitoria' => 'Vitória',
        'ippon' => 'Ippon',
        'waza_ari' => 'Waza-Ari',
        'yuko' => 'Yuko',
        'koka' => 'Koka',
        'yusei_gashi' => 'Yusei-Gashi'
    ],

    'golpes_pontos' => [
        'vitoria' => 0,
        'ippon' => 0,
        'waza_ari' => 10,
        'yuko' => 6,
        'koka' => 4,
        'yusei_gashi' => 2
    ],

    'fases_torneio' => [
        1 => 'Primeira Fase',
        2 => 'Quartas de Final',
        3 => 'Semi-Final',
        4 => 'Final'
    ],

    'equipes_por_fase' => [
        1 => 8,
        2 => 4,
        3 => 2,
        4 => 2
    ]
];