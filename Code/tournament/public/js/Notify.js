var Notify = function() {
	this.noty = {};
	this.options = {
		timeout: 5000,
		theme: 'relax',
		layout: 'centerRight',
		animation: {
			open: 'animated bounceIn',
			close: 'animated bounceOut'
		}
	};

	this.alert = function (text, title) {
		text = this.parseText(text, title)

		var options = $.extend(this.options, {
			text: text,
			type: 'alert'
		});

		this.noty = noty(options);
	};

	this.success = function (text, title) {
		text = this.parseText(text, title)

		var options = $.extend(this.options, {
			text: text,
			type: 'success'
		});

		this.noty = noty(options);
	};

	this.error = function (text, title) {
		text = this.parseText(text, title)

		var options = $.extend(this.options, {
			text: text,
			type: 'error'
		});

		this.noty = noty(options);
	};

	this.warning = function (text, title) {
		text = this.parseText(text, title)

		var options = $.extend(this.options, {
			text: text,
			type: 'warning'
		});

		this.noty = noty(options);
	};

	this.info = function (text, title) {
		text = this.parseText(text, title)

		var options = $.extend(this.options, {
			text: text,
			type: 'info'
		});

		this.noty = noty(options);
	};

	this.parseText = function (text, title) {
		title = $.trim(title);
		if (this.options.layout == 'top') {
			return (title != "") ? '<strong>' + title + '</strong>: ' + text : text;
		}

		return (title != "") ? '<strong>' + title + '</strong><br>' + text : text;
	};

	this.setOption = function (option, value) {
		this.options[option] = value;
	};

	this.destroy = function () {
		this.noty.destroy();
	};
}