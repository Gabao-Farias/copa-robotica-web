var RingueWatcher = function () {
    this.currentRound = null;

    this.init = function () {
        this.round_url = Urls.round_public_url;
        this.watch_url = Urls.watch_ringue_url;

        this.registerEvents();
    };

    this.registerEvents = function () {
        var self = this;

        $('.assistir').click(function () {
            var ringue_id = parseInt($(this).attr('id'));

            self.watchNew(ringue_id);
        });
    };

    this.redirectToRound = function (round) {
        if (round != null) {
            window.location.href = this.round_url + '/' + round.id;
        }
    };

    this.notifyWatching = function (ringue) {
        var notify = new Notify();
        notify.setOption('layout', 'top');
        notify.success('Aguardando batalha em <strong>' + ringue.nome + '</strong>');
    };

    this.watch = function(ringue_id) {
        var self = this;
        if (this.currentRound != null) {
            Echo.leave('ringue.' + this.currentRound);
        }

        this.currentRound = ringue_id;

        Echo.channel('ringue.' + ringue_id)
            .listen('RingueRoundEvent', function (e) {
                self.redirectToRound(e.round);
            });
    };

    this.disableWatchButton = function (ringue_id) {
        $('.assistir')
            .removeClass('disabled')
            .find('.watch-text')
            .text('Assistir');

        $('.assistir#' + ringue_id)
            .addClass('disabled')
            .find('.watch-text')
            .text('Assistindo');
    };

    this.watchNew = function (ringue_id) {
        var self = this;
        $.ajax({
            url: self.watch_url + '/' + ringue_id,
            type: 'GET',
            success: function (data) {
                self.notifyWatching(data.ringue)
                self.watch(data.ringue.id);
                self.disableWatchButton(data.ringue.id);
                self.redirectToRound(data.round);
            },
            error: function (xhr) {
                Responses.handle(xhr);
            }
        });
    };

    this.init();
};