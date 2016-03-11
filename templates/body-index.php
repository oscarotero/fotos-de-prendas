<?php $this->layout('html', ['title' => 'Fotos de prendas » Portada']) ?>

<section class="index">
	<header>
		<h1>Fotos de prendas</h1>
		<a id="crear-galeria-boton" class="boton" href="#">Nova galería de fotos...</a>
		
		<form id="crear-galeria-formulario" class="hidden" action="<?= $app->getRoute('nova-galeria'); ?>" method="post">
			<fieldset>
				<input type="text" name="galeria" placeholder="Nome da galería">
				<button class="boton">Crear</button>
			</fieldset>
		</form>
	</header>

	<ul class="galerias">
		<?php foreach ($app['galleries']->getAll() as $gallery): ?>
		<li>
			<a href="<?= $app->getRoute('galeria', ['galeria' => $gallery['basename']]); ?>"><?= $gallery['basename']; ?></a>
		</li>
		<?php endforeach; ?>
	</ul>
</section>