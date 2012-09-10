$(document).ready(function () {
	$('.fancybox').fancybox({
		padding: 5
	});

	$('#crear-galeria-boton').click(function () {
		$(this).hide();
		$('#crear-galeria-formulario').show();

		return false;
	});

	$('#engadir-fotos-boton').click(function () {
		var $input = $('#engadir-fotos-input');
		var $miniaturas = $('#engadir-fotos-miniaturas');
		var $progress = $input.find('progress').removeProp('value');

		$input.slideToggle('normal').filedrop({
			url: jsData.urlBase + 'subir-fotos/' + jsData.galeria,
			queuefiles: 5,
			maxfilesize: jsData.maxfilesize,
			allowedfiletypes: ['image/jpg', 'image/jpeg'],
			error: function(err, file) {
				switch(err) {
					case 'BrowserNotSupported':
						alert('Non podes subir arquivos porque o teu navegador é antigo. Usa firefox ou chrome');
						break;

					case 'TooManyFiles':
						alert('Non podes subir tantos arquivos ao mesmo tempo');
						break;

					case 'FileTooLarge':
						alert(file.name + ' é demasiado grande para subilo (' + jsData.maxfilesize + ' Mb máximo)');
						break;

					case 'FileTypeNotAllowed':
						alert(file.name + 'Non se pode subir porque non están soportados arquivos dese tipo');
					default:
						break;
				}
			},
			globalProgressUpdated: function (progress) {
				$progress.prop('value', progress);
			},
			drop: function () {
				$progress.show();
			},
			afterAll: function () {
				$input.slideUp('normal', function () {
					document.location.href = document.location.href;
				});
			},
			rename: function (name) {
				return name.toLowerCase();
			},
			uploadFinished: function (i, file, response, time) {
				if (response.error) {
					alert(file.name + ' devolveu o seguinte erro: ' + response.error);
					return;
				}

				$miniaturas.append('<li><img src="' + response.thumb + '" height="50"></li>');
			}
		});

		return false;
	});

	rotate = function (name, index) {
		$.post(jsData.urlBase + 'xirar-fotos/' + jsData.galeria, {
			file: name
		}, function () {
			var $img = $('#cmenu_' + index).siblings('a.fancybox').children('img');
			$img.prop('src', $img.prop('src') + '?' + $.now());
		});
	};

	$(document).on('dragenter', function () {
		if ($('#engadir-fotos-input').is(':hidden')) {
			$('#engadir-fotos-boton').click();
			$('html').animate({scrollTop: 0}, 500);
		}
	});
});