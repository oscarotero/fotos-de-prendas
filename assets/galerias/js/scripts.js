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
		var globalProgress = [];

		$input.slideToggle('normal').filedrop({
			url: jsData.urlBase + 'subir-fotos/' + jsData.galeria,
			queuefiles: 3,
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
			uploadStarted: function (i, file, len) {
				if ($progress.prop('max') === 1) {
					$progress.prop('max', (len * 100));
				}

				globalProgress[i] = 0;
				updateProgress($progress, globalProgress);
			},
			progressUpdated: function (i, file, progress) {
				globalProgress[i] = progress;
				updateProgress($progress, globalProgress);
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

				globalProgress[i] = 100;

				updateProgress($progress, globalProgress);

				$miniaturas.append('<li><img src="' + response.thumb + '" height="50"></li>');
			}
		});

		return false;
	});
	
	var updateProgress = function ($progress, progress) {
		var value = 0;

		for (var key in progress) {
			value += (progress[key] * 1);
		}

		$progress.prop('value', value);
	}

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