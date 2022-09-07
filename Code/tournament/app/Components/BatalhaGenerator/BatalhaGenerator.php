<?php

namespace App\Components\BatalhaGenerator;

use App\Equipe;

class BatalhaGenerator
{
	/**
	 * Armazena as batalhas com as equipes participantes.
	 * 
	 * @var array
	 */
	protected $batalhas = [];

	/**
	 * Conta em "quantas" batalhas cada equipe participa.
	 * 
	 * @var array
	 */
	protected $countBatalhas = [];

	/**
	 * Armazena as equipes.
	 * 
	 * @var array
	 */
	protected $equipes = [];

	/**
	 * Armazena as equipes disponíveis para batalhas (que já não estão em 3 batalhas).
	 * 
	 * @var array
	 */
	protected $equipesDisponiveis = [];

	/**
	 * Máximo de batalhas para cada equipe. Usado pelo gerador.
	 *
	 * @var  int
	 */
	protected $maxBatalhas = 3;

	public function __construct($seed = true)
	{
        if ($seed) {
            $equipes = Equipe::where('presente', 1)->get()->pluck('id', 'id')->toArray();
            $this->setEquipes($equipes);
        }

		$this->batalhas = [];
		$this->countBatalhas = [];
        $this->setMaxBatalhas(config('torneio.equipe_max_batalhas'));
	}

	/**
	 * Gera uma batalha com as equipes disponíveis.
	 * 
	 * @return void
	 */
	public function gerarBatalhaRand()
	{
		$equipes = $this->procurarBatalhaRand();

		$this->setaBatalha($equipes[0], $equipes[1]);
	}

	/**
	 * Procura uma possível batalha com as equipes disponíveis.
	 * 
	 * @return array
	 */
	protected function procurarBatalhaRand()
	{
		while (true)
		{
			$equipe1 = array_rand($this->equipesDisponiveis, 1);
			
			$equipesBackup = $this->equipesDisponiveis;

			//Remove equipe 1 da lista de equipes temporariamente
			//para o próximo rand.
			unset($this->equipesDisponiveis[$equipe1]);
			
			$equipe2 = array_rand($this->equipesDisponiveis, 1);

			//Retorna a lista de equipes original.
			$this->equipesDisponiveis = $equipesBackup;

			if (! $this->batalhaExiste($equipe1, $equipe2)) {
				break;
			}
		}

		return [$equipe1, $equipe2];
	}

	/**
	 * Rotina para registrar a batalha e a contagem de batalha das equipes.
	 * 
	 * @param  int $equipe1 	Id da equipe 1.
	 * @param  int $equipe2 	Id da equipe 2.
	 * @return void
	 */
	protected function setaBatalha($equipe1, $equipe2)
	{
		$this->batalhas[] = [
			'equipe1' => $equipe1,
			'equipe2' => $equipe2
		];

		$this->incrementaBatalhas($equipe1);
		$this->incrementaBatalhas($equipe2);

		$this->verificaDisponivel($equipe1);
		$this->verificaDisponivel($equipe2);
	}

	/**
	 * Gera uma batalha para uma equipe específica.
	 * 
	 * @param  Equipe $equipe
	 * @return void
	 */
	public function gerarBatalhaEquipe($equipe)
	{
		while (true)
		{
			$equipesBackup = $this->equipes;

			//Remove equipe 1 da lista de equipes temporariamente
			//para o próximo rand.
			unset($this->equipes[$equipe]);
			
			$equipe2 = array_rand($this->equipes, 1);

			//Retorna a lista de equipes original.
			$this->equipes = $equipesBackup;

			if (! $this->batalhaExiste($equipe, $equipe2)) {
				break;
			}
		}

		$this->setaBatalha($equipe, $equipe2);
	}

	/**
	 * Gera um número "n" de batalhas.
	 * 
	 * @param  integer $quantidade
	 * @return void
	 */
	public function gerarBatalhasRand($quantidade = 1)
	{
		for ($i = 0; $i < $quantidade; $i++)
		{
			$this->gerarBatalhaRand();
		}
	}

	/**
	 * Gera batalhas enquanto a condição "$condicao" for verdadeira.
	 * 
	 * @param  Callback $condicao
	 * @return void
	 */
	public function gerarBatalhasCondicao()
	{
		while ($this->equipesSemBatalha())
		{
			$this->gerarBatalhaRand();
		}
	}

	/**
	 * Gera batalhas complementares para as equipes que ficaram com menos que o máximo
	 * de batalhas.
	 * 
	 * @return void
	 */
	public function complementarBatalhas()
	{
		foreach ($this->getCountBatalhas() as $id => $count)
		{
			if ($count < $this->getMaxBatalhas()) {
				$diferenca = abs($count - $this->getMaxBatalhas());

				//Gerar batalhas até chegar em 3.
				for ($i = 0; $i < $diferenca; $i++)
				{
					$this->gerarBatalhaEquipe($id);
				}
			}
		}
	}

	/**
	 * Verifica quantas equipes estão com menos que o limite máximo de batalhas.
	 * 
	 * @return void
	 */
	public function equipesSemBatalha()
	{
		if (count($this->countBatalhas) < count($this->equipes)) {
			return true;
		}

		$numMenorMax = 0;
		foreach ($this->countBatalhas as $count)
		{
			if ($count < $this->getMaxBatalhas()) {
				$numMenorMax++;
			}

			if ($numMenorMax > 1) {
				break;
			}
		}

		//Se mais que uma está com menos que o limite, podemos continuar gerando batalhas.
		if ($numMenorMax > 1) {
			return true;
		}

		//Senão, temos que parar para evitar loop infinito.
		return false;
	}

    /**
     * Gera uma batalha na sequencia das equipes disponíveis.
     *
     * @return void
     */
	public function gerarBatalhaSequencia()
    {
        $equipe1 = current($this->equipesDisponiveis);
        $equipe2 = next($this->equipesDisponiveis);
        next($this->equipesDisponiveis);

        $this->setaBatalha($equipe1, $equipe2);
    }

    /**
     * Gera batalhas na sequencia das equipes disponíveis.
     *
     * @param $numBatalhas
     * @return void
     */
    public function gerarBatalhasSequencia()
    {
        while (next($this->equipesDisponiveis))
        {
            prev($this->equipesDisponiveis);
            $this->gerarBatalhaSequencia();
        }
    }

    /**
     * Define as equipes que serão usadas para gerar batalhas.
     *
     * @param array $equipes
     * @param bool $disponiveis
     * @return void
     */
	public function setEquipes(array $equipes, $disponiveis = true)
    {
        $this->equipes = $equipes;
        reset($this->equipes);

        if ($disponiveis) {
            $this->equipesDisponiveis = $equipes;
            reset($this->equipesDisponiveis);
        }
    }

    public function getEquipes()
    {
        return $this->equipes;
    }

	/**
	 * Retorna a lista de batalhas geradas.
	 * 
	 * @return array
	 */
	public function getBatalhas()
	{
		return $this->batalhas;
	}

	/**
	 * Retorna a contagem de batalhas por equipes.
	 * 
	 * @return array
	 */
	public function getCountBatalhas()
	{
		return $this->countBatalhas;
	}

	/**
	 * Seta o máximo de batalhas para cada equipe.
	 * 
	 * @param int $maxBatalhas
	 */
	public function setMaxBatalhas($maxBatalhas)
	{
		$this->maxBatalhas = $maxBatalhas;
	}

	/**
	 * Retorna o máximo de batalhas definido para cada equipe.
	 * 
	 * @return int
	 */
	public function getMaxBatalhas()
	{
		return $this->maxBatalhas;
	}

	/**
	 * Verifica se já existe uma batalha entre as equipes fornecidas.
	 * 
	 * @param  Equipe $equipe1
	 * @param  Equipe $equipe2
	 * @return boolean
	 */
	protected function batalhaExiste($equipe1, $equipe2)
	{
		$existe = false;
		foreach ($this->batalhas as $batalha)
		{
			$bEquipe1 = $batalha['equipe1'];
			$bEquipe2 = $batalha['equipe2'];

			if (($bEquipe1 == $equipe1 && $bEquipe2 == $equipe2) || ($bEquipe2 == $equipe1 && $bEquipe1 == $equipe2)) {
				$existe = true;
				break;
			}
		}

		return $existe;
	}

	/**
	 * Incrementa a contagem de batalhas de uma determinada equipe.
	 * 
	 * @param  Equipe $equipe
	 * @return void
	 */
	protected function incrementaBatalhas($equipe)
	{
		if (isset($this->countBatalhas[$equipe])) {
			$this->countBatalhas[$equipe]++;
		} else {
			$this->countBatalhas[$equipe] = 1;
		}
	}

	/**
	 * Verifica se uma equipe está disponível para batalha (se já não está em 3 batalhas).
	 * 
	 * @param  Equipe $equipe
	 * @return boolean
	 */
	protected function verificaDisponivel($equipe)
	{
		if (isset($this->countBatalhas[$equipe]) && $this->countBatalhas[$equipe] >= $this->getMaxBatalhas()) {
			unset($this->equipesDisponiveis[$equipe]);
		}
	}
}