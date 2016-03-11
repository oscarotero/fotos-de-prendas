<?php $this->layout('html', ['title' => 'Fotos de prendas » '.$gallery]) ?>

<?php $max = intval(ini_get('upload_max_filesize')); ?>

<script type="text/javascript" charset="utf-8">
var jsData = <?= json_encode(array(
	'urlBase' => $app->getUrl(),
	'maxfilesize' => $max,
	'galeria' => $gallery
)); ?>;
</script>

<section class="galeria">
	<header>
		<h1><a href="<?= $app->getRoute('index'); ?>">Fotos de prendas</a> / <?= $gallery; ?></h1>
		<a id="engadir-fotos-boton" class="boton" href="#">Engadir fotos...</a>
	</header>

	<div id="engadir-fotos-input" class="zona-dragdrop hidden" data-url="<?= $app->getRoute('subir-foto', ['galeria' => $gallery]); ?>">
		<div id="mensaxe">Arrastra aqui as fotos que queiras subir
			<p>Só imaxes (jpg) e cun máximo de <?= $max; ?>Mb por imaxe.</p>
		</div>

		<progress max="1" class="hidden"></progress>

		<ul id="engadir-fotos-miniaturas"></ul>
	</div>

	<ul class="videos">
		<?php foreach ($app['galleries']->getVideos($gallery) as $video): ?>
		<li>
			<video width="500" controls src="<?= $app->getUrl('images', $video['path']) ?>"></video>
		</li>
		<?php endforeach; ?>
	</ul>

	<ul class="fotos">
		<?php foreach ($app['galleries']->getPhotos($gallery) as $k => $foto): ?>
		<li contextmenu="cmenu_<?= $k; ?>">
			<a href="<?= $app->getUrl('images', $foto['path']); ?>" class="fancybox" rel="galeria">
				<img src="<?= $app->getUrl('images', $foto['path']); ?>" alt="Foto">
			</a>

			<menu type="context" id="cmenu_<?= $k; ?>">
				<menuitem label="Xirar 90º cara a dereita" onclick="rotateImg('<?= $foto['basename']; ?>', <?= $k ?>);"></menuitem>
				<menuitem label="Eliminar esta foto" onclick="deleteImg('<?= $foto['basename']; ?>', <?= $k ?>);"></menuitem>
			</menu>
		</li>
		<?php endforeach; ?>
	</ul>
</section>
