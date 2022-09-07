var Round = function(round_data, isClient) {
    this.isClient = isClient;
	this.round_data = $.parseJSON(round_data);
    this.api = new RoundApi(this.round_data.id, isClient);
    this.url_batalhas = Urls.batalha_url;
	this.counter;
    this.pollingCounter;
    this.nextRoundTimeout = 60;
    this.endBattleTimeout = 10;

	this.init = function () {
        if (this.isClient) {
            this.url_rounds = Urls.round_public_url;
            this.url_batalhas = Urls.batalha_public_url;
        } else {
            this.url_rounds = Urls.round_url;
            this.url_batalhas = Urls.batalha_url;
        }

		this.registerEvents();
		this.registerChannels();

		if (this.round_data.status == 'em_andamento') {
			this.startCounter(this.round_data);
		}

		this.notifyNewRound();
	};

	this.notifyNewRound = function () {
        var notify = new Notify();
        notify.setOption('layout', 'top');
        notify.setOption('timeout', 5000);
        notify.warning('Atenção para o <strong>round ' + this.round_data.ordem + '</strong>!');
    };

	this.handleRoundControl = function () {
		var button = $('.partida-control .control'),
			state = parseInt(button.data('state'));

		switch(state) {
            case 0:
                this.api.playRound();
            break;
            case 1:
                this.api.pauseRound();
            break;
            case 2:
                this.promptNextRound();
            break;
            case 3:
                this.promptExitBattle();
            break;
        }
	};

	this.promptNextRound = function () {
        var self = this;
        Alerter.confirm("Deseja ir para o próximo round? <strong>Caso este seja o último round a batalha será finalizada.</strong>", "Ir para o próximo round",
            function () {
                self.api.nextRound();
            });
    };

    this.promptExitBattle = function () {
        var self = this;
        Alerter.confirm("Deseja finalizar a Batalha?", "Finalizar Batalha", function () {
            self.api.exitBattle(self.round_data.batalha);
        });
    };

    this.promptRemoveAttack = function (equipeNome, ataqueId, ataqueNome) {
        var self = this;
        Alerter.confirm("Deseja remover <strong>" + ataqueNome + "</strong> da equipe <strong>" + equipeNome + "</strong>?", "Remover Ponto", function () {
            self.api.removeTeamAttack(ataqueId);
        });
    };

	this.switchControl = function (mode) {
		var button = $('.partida-control .control');

		button.removeClass('glyphicon-play glyphicon-pause glyphicon-log-out');
        switch(mode) {
            case 'play':
                button.addClass('glyphicon-play');
                button.data('state', 0);
            break;
            case 'next':
                button.addClass('glyphicon-forward');
                button.data('state', 2);
            break;
            case 'pause':
                button.addClass('glyphicon-pause');
                button.data('state', 1);
            break;
            case 'exit':
                button.addClass('glyphicon-log-out');
                button.data('state', 3);
            break;
        }
	};

	this.notifyPlay = function () {
		var notify = new Notify();
		notify.setOption('layout', 'top');
		notify.success('Round Retomado!');
	};

	this.notifyPause = function () {
		var notify = new Notify();
		notify.setOption('layout', 'top');
		notify.warning('Round Parado!');
	};

	this.notifyEnd = function () {
		var notify = new Notify();
		notify.setOption('layout', 'top');
		notify.error('Fim do Round ' + this.round_data.ordem + '!');
	};

    this.teamAttack = function (button) {
        var team_id = parseInt(button.parent().data('equipe-id')),
            name = button.parent().data('equipe-nome'),
            type = button.data('type'),
            attackName = Lang.nome_golpes[type],
            self = this;

        Alerter.confirm("Deseja registrar <strong>" + attackName + "</strong> para a equipe <strong>" + name + "</strong>?", "Confirmar Ponto", function () {
            self.api.registerAttack(team_id, type);
        });
    };

	this.registerEvents = function() {
		var self = this;

		$('.partida-control .control').off('click');
		$('.partida-control .control').click(function () {
			self.handleRoundControl();
		});

        $('.buttons-set button').off('click');
        $('.buttons-set button:not(.disabled)').click(function () {
            self.teamAttack($(this));
        });

        $('span.remove-ponto').off('click');
        $('span.remove-ponto').click(function() {
            var equipeNome = $(this).data('equipe-nome'),
                ataqueNome = $(this).data('ataque-nome'),
                ataqueId = $(this).attr('id');
            self.promptRemoveAttack(equipeNome, ataqueId, ataqueNome);
        });

        $(window).off('keypress');
        $(window).on('keypress', function (e) {
            if (e.which == 32) {
                e.preventDefault();
                self.handleRoundControl();
            }
        });
	};

	this.updateRoundStatus = function (round) {
		$('.round-status').html('(' + Lang.status_round[round.status] + ')');
	};

	this.handlePlayEvent = function (round) {
		this.switchControl('pause');
		this.updateRoundStatus(round);
		this.notifyPlay();
		this.startCounter(round);
        this.registerEvents();
    };

	this.handlePauseEvent = function (round) {
		this.switchControl('play');
		this.updateRoundStatus(round);
		this.notifyPause();
		this.stopCounter(round);
        this.registerEvents();
    };

	this.handleEndRoundEvent = function (round) {
		$('.partida-timer').fadeOut();
		$('.partida-message').fadeIn();
		this.updateRoundStatus(round);
        this.notifyEnd();
		this.stopCounter(round);
        this.switchControl('next');
        this.registerEvents();
	};

	this.timeoutContainer = function (time) {
        return '<span class="font-bold" id="end-countdown" data-time="' + time + '">' + this.getTime(time) + '</span>'
    };

    this.endCountdown = function (nextRound, callback) {
        var notify = new Notify();
        notify.setOption('timeout', false);
        notify.setOption('layout', 'top');
        if (nextRound == null) {
            notify.warning("A batalha encerra em " + this.timeoutContainer(this.endBattleTimeout));
        } else {
            notify.warning("Indo para o <strong>round " + nextRound.ordem + "</strong> em " + this.timeoutContainer(this.nextRoundTimeout));
        }

        var timeContainer = $('#end-countdown'),
            self = this,
            seconds;
        setInterval(function () {
            seconds = parseInt(timeContainer.data('time'));
            if (seconds == 0) {
                callback();
            } else {
                seconds--;
                timeContainer.data('time', seconds);
                timeContainer.html(self.getTime(seconds));
            }
        }, 1000);
    };

    this.handleNextRoundEvent = function (round, nextRound, winner) {
        var self = this;
        this.notifyRoundWinner(winner);
        this.endCountdown(nextRound, function () {
            window.location.href = self.url_rounds + '/' + nextRound.id;
        });
    };

    this.handleEndBattleEvent = function (battle, battleWinner, winnerDrawn) {
        var self = this;
        this.notifyBattleWinner(battleWinner, winnerDrawn);
        this.endCountdown(null, function () {
            window.location.href = self.url_batalhas;
        });
    };

    this.notifyRoundWinner = function (winner) {
        if (winner != null) {
            Alerter.info("A equipe <strong>" + winner.nome + "</strong> venceu o round!", "Resultado do Round", false)
        } else {
            Alerter.info("O round terminou em <strong>empate</strong>!", "Resultado do Round", false);
        }
    };

    this.notifyBattleWinner = function (battleWinner, winnerDrawn) {
        if (battleWinner != null) {
            if (winnerDrawn) {
                Alerter.info('<span class="wHighlight">Após sorteio</span>, a equipe <strong>' + battleWinner.nome + '</strong> venceu a batalha!', "Resultado da Batalha", 10000);
            } else {
                Alerter.info("A equipe <strong>" + battleWinner.nome + "</strong> venceu a batalha!", "Resultado da Batalha", 10000);
            }
        } else {
            Alerter.info('A batalha terminou em <span class="wHighlight">empate</span>!', "Resultado da Batalha", 10000);
        }
    };

    this.notifyAttack = function (equipe, ponto, side, remove) {
        remove = (remove == undefined) ? false : remove;

        var pontosGolpe = Lang.pontos_golpes[ponto.tipo_ponto],
            tipoPonto = Lang.nome_golpes[ponto.tipo_ponto];

        pontosGolpe = (pontosGolpe != '') ? ' (' + pontosGolpe + ') ' : '';
        if (remove) {
            var text = '<strong>' + tipoPonto + '</strong> <span class="wHighlight">removido</span> da equipe <strong>' + equipe.nome + '</strong>';

            Alerter.info(text, tipoPonto + " removido");
        } else {
            var text = '<strong>' + tipoPonto + '</strong> para a equipe <strong>' + equipe.nome + '' + pontosGolpe + '</strong>';

            Alerter.info(text, tipoPonto);
        }
    };

    this.handleAttackEvent = function (round, equipe, equipePontos, ponto) {
        var pontosEquipe = $('.round-pontos#' + equipePontos.id),
            valorPontos = parseInt(pontosEquipe.data('pontos')),
            novosPontos = ponto.pontos + valorPontos,
            self = this;

        pontosEquipe.data('pontos', novosPontos)
            .html(novosPontos + ' Pontos');

        var side = (equipePontos.id == self.round_data.batalha.equipe1.id) ? 'left' : 'right';
        this.notifyAttack(equipe, ponto, side);

        this.api.loadPointsList(round, equipePontos, function () {
            self.registerEvents()
        });
    };

    this.handleRemoveAttackEvent = function (round, attack) {
        var pontosEquipe = $('.round-pontos#' + attack.equipe.id),
            valorPontos = parseInt(pontosEquipe.data('pontos')),
            novosPontos = valorPontos - attack.pontos,
            self = this;

        pontosEquipe.data('pontos', novosPontos)
            .html(novosPontos + ' Pontos');

        this.api.loadPointsList(round, attack.equipe, function () {
            self.registerEvents();
        });

        var side = (attack.equipe.id == this.round_data.batalha.equipe1.id) ? 'left' : 'right';
        this.notifyAttack(attack.equipe, attack, side, true);
    };

	this.registerChannels = function () {
		var self = this;
		Echo.channel('round.' + self.round_data.id)
			.listen('PlayRoundEvent', function (e) {
				self.handlePlayEvent(e.round);
			})
			.listen('PauseRoundEvent', function (e) {
				self.handlePauseEvent(e.round);
			})
			.listen('EndRoundEvent', function (e) {
				self.handleEndRoundEvent(e.round);
			})
            .listen('AttackEvent', function (e) {
                self.handleAttackEvent(e.round, e.equipe, e.equipePontos, e.ponto);
            })
            .listen('NextRoundEvent', function (e) {
                self.handleNextRoundEvent(e.round, e.proximoRound, e.vencedor);
            })
            .listen('RemoverPontoEvent', function (e) {
                self.handleRemoveAttackEvent(e.round, e.ponto);
            });

        Echo.channel('batalha.' + self.round_data.batalha.id)
            .listen('EndBatalhaEvent', function (e) {
                self.handleEndBattleEvent(e.batalha, e.vencedorBatalha, e.vencedorSorteado);
            })
	};

	this.getTime = function (seconds) {
        minutes = parseInt(seconds / 60);
        seconds -= minutes * 60;

        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        return minutes + ':' + seconds
    };

	this.updateClock = function () {
		var timer = $('.partida-timer'),
			seconds = parseInt(timer.data('time'));

		timer.html(this.getTime(seconds));
	};

	this.checkRoundStatus = function () {
		this.api.checkRoundStatus();
	};

	this.enableButtons = function () {
		$('.buttons-set button')
				.removeClass('disabled')
				.parent()
				.removeAttr('title')
				.removeAttr('data-toggle')
				.tooltip('destroy');
	};

	this.disableButtons = function () {
		$('.buttons-set button')
				.removeClass('disabled')
				.addClass('disabled')
				.parent()
				.attr('title', 'Pare o Round!')
				.attr('data-toggle', 'tooltip')
				.tooltip();
	};

	this.stopCounter = function (round) {
		var timer = $('.partida-timer');
		
		timer.data('time', round.tempo_restante);
		clearInterval(this.counter);
        if (! this.isClient) {
            clearInterval(this.pollingCounter);
        }
		this.updateClock();
		this.enableButtons();
	};

	this.startCounter = function (round) {
		var self = this,
			timer = $('.partida-timer');

		timer.data('time', round.tempo_restante);
		this.disableButtons();

		this.counter = setInterval(function () {
			var seconds = parseInt(timer.data('time'));

			if (seconds == 0 && ! self.isClient) {
				self.checkRoundStatus();
			} else if (seconds > 0) {
				seconds--;
				timer.data('time', parseInt(seconds));
				self.updateClock();
			}
		}, 1000);

        if (! this.isClient) {
            this.pollingCounter = setInterval(function () {
                self.checkRoundStatus();
            }, 5000);
        }
	};

	this.init();
};