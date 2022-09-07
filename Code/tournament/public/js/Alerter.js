var Alerter = {
	options: {
		id: '#app-modal',
		closeButton: 'Fechar',
		confirmButton: 'Confirmar'
	},

    shown: false,
	timeout: null,

	reset: function () {
		$(this.options.id).off('shown.bs.modal');
		$(this.options.id).off('hidden.bs.modal');
		this.offConfirm();
		$(this.options.id + ' .modal-footer .first-button').css('display', 'inline-block');
		$(this.options.id + ' .modal-footer .second-button').css('display', 'inline-block');
        this.showFooter();
	},

	alert: function (message, title, addOptions) {
		this.reset();

		var options = this.setOptions(addOptions);
		this.setContent(message, title);

		$(options.id + ' .modal-footer .first-button')
				.text(options.closeButton);
		$(options.id + ' .modal-footer .second-button')
				.css('display', 'none');

		this.invoke();
		this.focusOnFirst();
	},

	confirm: function (message, title, callback, addOptions) {
		this.reset();

		var options = this.setOptions(addOptions);
		this.setContent(message, title);

		$(options.id + ' .modal-footer .first-button')
				.text(options.closeButton);
		$(options.id + ' .modal-footer .second-button')
				.text(options.confirmButton);

		this.invoke();
		this.focusOnSecond();
		this.onConfirm(callback);
	},

    setInfoModal: function (message, title, timeout) {
        this.reset();
        this.hideFooter();
        this.setContent(message, title);
        this.invoke();
        this.hideTimeout(timeout);
    },

	info: function (message, title, timeout) {
        var self = this;
        if (this.shown) {
            $(this.options.id).on('hidden.bs.modal', function () {
                self.setInfoModal(message, title, timeout);
            });
        } else {
            this.setInfoModal(message, title, timeout);
        }
    },

	focusOnFirst: function () {
		var self = this;
		$(this.options.id).on('shown.bs.modal', function () {
			$(self.options.id + ' .modal-footer .first-button').focus();
		});
	},

	focusOnSecond: function () {
		var self = this;
		$(this.options.id).on('shown.bs.modal', function () {
			$(self.options.id + ' .modal-footer .second-button').focus();
		});
	},

    hideFooter: function() {
        $(this.options.id + ' .modal-footer').css('display', 'none');
    },

    showFooter: function () {
        $(this.options.id + ' .modal-footer').css('display', 'block');
    },

	onConfirm: function (callback) {
	    var self = this;
		$(this.options.id + ' .modal-footer .second-button').click(function () {
			if (typeof callback == 'function') {
				$(self.options.id).modal('hide');
				callback();
			}
		});
	},

	offConfirm: function () {
		$(this.options.id + ' .modal-footer .second-button').off('click');
	},

	setOptions: function (addOptions) {
		if (typeof addOptions == 'object') {
			return $.extend(this.options, addOptions);
		}

		return this.options;
	},

	setContent: function (message, title) {
		$(this.options.id + ' .modal-title').html(title);
		$(this.options.id + ' .modal-body').html('<p>' + message + '</p>');
	},

	invoke: function () {
		$(this.options.id).modal();
        this.shown = true;

        var self = this;

        $(this.options.id).on('hidden.bs.modal', function () {
            clearTimeout(self.timeout);
            self.shown = false;
        });
	},

    hideTimeout: function (timeout) {
        if (timeout == undefined) {
            timeout = 5000;
        }

        var self = this;

        if (!! timeout) {
            $(this.options.id).on('shown.bs.modal', function () {
                self.timeout = setTimeout(function () {
                    $(self.options.id).modal('hide');
                }, timeout)
            });
        }
    }
};