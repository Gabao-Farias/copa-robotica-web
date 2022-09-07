var RoundApi = function (round_id, isClient) {
    this.round_id = round_id;
    this.url = Urls.round_api;
    this.public_url = Urls.round_public_api;
    this.isClient = isClient;

    this.playRound = function () {
        var self = this;
        $.ajax({
            url: self.url + '/play/' + self.round_id,
            type: 'GET',
            error: function (xhr) {
                Responses.handle(xhr);
            }
        });
    };

    this.pauseRound = function () {
        var self = this;
        $.ajax({
            url: self.url + '/pause/' + self.round_id,
            type: 'GET',
            error: function (xhr) {
                Responses.handle(xhr);
            }
        });
    };

    this.checkRoundStatus = function () {
        var self = this;
        $.ajax({
            url: self.url + '/check-status/' + self.round_id,
            type: 'GET',
            error: function(xhr) {
                Responses.handle(xhr);
            }
        });
    };

    this.registerAttack = function (team_id, attack_type) {
        var self = this;
        $.ajax({
            url: self.url + '/registrar-golpe/' + self.round_id + '/' + team_id + '/' + attack_type,
            type: 'GET',
            error: function (xhr) {
                Responses.handle(xhr);
            }
        });
    };

    this.nextRound = function () {
        var self = this;
        $.ajax({
            url: self.url + '/proximo-round/' + self.round_id,
            type: 'GET',
            error: function (xhr) {
                Responses.handle(xhr);
            }
        });
    };

    this.exitBattle = function (battle) {
        var self = this;
        $.ajax({
            url: self.url + '/finalizar-batalha/' + battle.id,
            type: 'GET',
            error: function (xhr) {
                Responses.handle(xhr);
            }
        });
    };

    this.loadPointsList = function (round, team, callback) {
        var self = this;
        $.ajax({
            url: self.public_url + '/listar-pontos/' + round.id + '/' + team.id + '?isClient=' + self.isClient,
            type: 'GET',
            success: function(data) {
                $('#' + team.id + '.pontos-container').html(data);
            },
            error: function (xhr) {
                Responses.handle(xhr);
            },
            complete: function () {
                callback();
            }
        });
    };

    this.removeTeamAttack = function(attack) {
        var self = this;
        $.ajax({
            url: self.url + '/remover-ponto/' + attack,
            type: 'GET',
            error: function(xhr) {
                Responses.handle(xhr);
            }
        });
    };
};