var Responses = {
	handle: function (xhr) {
		switch (xhr.status) {
			case 401:
				this.unauthenticated(xhr);
			break;
			case 500:
				this.internalError();
			break;
			case 403:
				this.internalError();
			break;
			case 422:
				this.unprocessable(xhr);
			break;
			default:
				this.unknown();
			break;
		}
	},

	unauthenticated: function (xhr) {
		var notify = new Notify();
		notify.setOption('layout', 'top');

		notify.error("Faça login para realizar esta ação.", "Não Autenticado");
	},

	internalError: function () {
		var notify = new Notify();
		notify.setOption('layout', 'top');

		notify.error("Erro Interno no Servidor.", "Erro Interno");
	},

	forbidden: function () {
		var notify = new Notify();
		notify.setOption('layout', 'top');

		notify.error("Acesso negado pelo servidor.", "Acesso Negado");
	},

	unprocessable: function (xhr) {
		var json = xhr.responseJSON,
			notify = new Notify();
		notify.setOption('layout', 'top');

		notify.error(json.message, json.title);
	},

	unknown: function(xhr) {
		notify = new Notify();
		notify.setOption('layout', 'top');

		notify.error("Um erro desconhecido ocorreu.", "Erro desconhecido");
		console.log(xhr);
	}
}