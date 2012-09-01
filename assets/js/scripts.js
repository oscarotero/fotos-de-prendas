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
		var $progress = $input.find('progress').removeProp('value');

		$input.slideToggle('normal').filedrop({
			url: $input.data('url'),
			maxfiles: 200,
			maxfilesize: 100,
			allowedfiletypes: ['image/jpg', 'image/jpeg'],
			error: function(err, file) {
				if (err === 'BrowserNotSupported') {
					alert('Non podes subir arquivos porque o teu navegador é antigo');
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
			}
		});

		return false;
	});

	$(document).on('dragenter', function () {
		if ($('#engadir-fotos-input').is(':hidden')) {
			$('#engadir-fotos-boton').click();
			$('html').animate({scrollTop: 0}, 500);
		}
	});
});