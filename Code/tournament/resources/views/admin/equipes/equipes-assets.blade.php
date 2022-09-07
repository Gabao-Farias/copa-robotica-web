<script>
//Event listeners dos integrantes
function bindEvents() {
	$('.remove-integrante').off('click');
    $('.set-capitao').off('change');

	$('.remove-integrante').click(function () {
        var isCapitao = $(this).parent().prev().find('.set-capitao').prop('checked');

		if ($('.integrante').length > 1) {
			$(this).parents('.integrante').remove();
            if (isCapitao) {
                $('.set-capitao').first().prop('checked', true);
            }
            orderNames();
		} else {
			alert('É necessário cadastrar pelo menos um integrante.');
		}
	});

    $('.set-capitao').on('change', function() {
        if ($(this).prop('checked')) {
            var name = $(this).attr('name');

            $('.set-capitao').each(function() {
                if ($(this).attr('name') !== name) { 
                    $(this).prop('checked', false);
                }
            });
        }
    });
}

//Ordenar vetor de integrantes
function orderNames() {
    $('.integrante').each(function (i, integrante) {
        var input = $(this).find('input'),
            regexp = /\[[0-9]+\]/;
        
        input.each(function() {
            $(this).attr('name', $(this).attr('name').replace(regexp, '[' + i + ']'));
        });
    });
}

$(function() {
    //Preview de imagem
    var pathFotoEquipe = $('#foto_equipe_path').val().trim();
    var pathFotoRobo = $('#foto_robo_path').val().trim();

    if (pathFotoEquipe != "") {
        $('<a href="' + pathFotoEquipe + '" target="_blank"><img src="{{ url('/') }}/' + pathFotoEquipe + '"/></a>').appendTo('.foto-preview-equipe');
        $('.foto-preview-equipe').fadeIn();
    }

    if (pathFotoRobo != "") {
        $('<a href="' + pathFotoRobo + '" target="_blank"><img src="{{ url('/') }}/' + pathFotoRobo + '"/></a>').appendTo('.foto-preview-robo');
        $('.foto-preview-robo').fadeIn();
    }

    //Adicionar integrante
	$('#adicionar-integrante').click(function () {
		var integrante = $('.integrante').first().clone(),
            input = integrante.find('.integrante-input'),
            integranteId = integrante.find('.integrante-id'),
            capitao = integrante.find('.set-capitao'),
            numIntegrantes = $('.integrante').length;

        input.val('');
        integranteId.val('');
        capitao.prop('checked', false);

        $('#integrantes-container').append(integrante);
        orderNames();
        bindEvents();

        input.focus();
	});

	bindEvents();

    //Upload de fotos
    $('.upload-foto-equipe').fileupload({
        url: '{{ url('admin/upload-foto/equipe') }}',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000,

        start: function (e, data) {
            $('#progress-equipe').fadeIn();
            $('.foto-preview-equipe').fadeOut();
        },

        stop: function (e, data) {
            $('#progress-equipe').fadeOut();
        },

        done: function (e, data) {
            $('#foto_equipe_path').val(data.result.foto_public_path);

            $('#upload-status-equipe')
                .fadeIn()
                .removeClass('text-danger text-success')
                .addClass('text-success')
                .html('<strong>Upload efetuado com sucesso!</strong>');

            $('.foto-preview-equipe').empty();
            $('<img src="' + data.result.foto_public_path + '"/>').appendTo('.foto-preview-equipe');
            $('.foto-preview-equipe').fadeIn();
        },

        fail: function (e, data) {
            var errors = '<strong>Os seguintes erros ocorreram:</strong><br>';

            $.each(data.jqXHR.responseJSON, function (key, value) {
                $.each(value, function (fKey, fValue) {
                    errors += fValue + '<br>';
                });
            });

            errors = errors.replace(/\<br\>+$/, '');

            $("#upload-status-equipe")
                .fadeIn()
                .removeClass('text-success text-danger')
                .addClass("text-danger")
                .html(errors);
        },

        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);

            $('#progress-equipe .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    });

    //Upload de fotos
    $('.upload-foto-robo').fileupload({
        url: '{{ url('admin/upload-foto/robo') }}',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000,

        start: function (e, data) {
            $('#progress-robo').fadeIn();
            $('.foto-preview-robo').fadeOut();
        },

        stop: function (e, data) {
            $('#progress-robo').fadeOut();
        },

        done: function (e, data) {
            $('#foto_robo_path').val(data.result.foto_public_path);

            $('#upload-status-robo')
                    .fadeIn()
                    .removeClass('text-danger text-success')
                    .addClass('text-success')
                    .html('<strong>Upload efetuado com sucesso!</strong>');

            $('.foto-preview-robo').empty();
            $('<img src="' + data.result.foto_public_path + '"/>').appendTo('.foto-preview-robo');
            $('.foto-preview-robo').fadeIn();
        },

        fail: function (e, data) {
            var errors = '<strong>Os seguintes erros ocorreram:</strong><br>';

            $.each(data.jqXHR.responseJSON, function (key, value) {
                $.each(value, function (fKey, fValue) {
                    errors += fValue + '<br>';
                });
            });

            errors = errors.replace(/\<br\>+$/, '');

            $("#upload-status-robo")
                    .fadeIn()
                    .removeClass('text-success text-danger')
                    .addClass("text-danger")
                    .html(errors);
        },

        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);

            $('#progress-robo .progress-bar').css(
                    'width',
                    progress + '%'
            );
        }
    });
});
</script>