<?php $max = intval(ini_get('upload_max_filesize')); ?>

<script type="text/javascript" charset="utf-8">
var jsData = <?php echo json_encode(array(
	'urlBase' => $this->App->url,
	'maxfilesize' => $max,
	'galeria' => $galeria['nome']
)); ?>;
</script>

<section class="galeria">
	<header>
		<h1><a href="<?php echo $this->App->url; ?>"><?php echo $titulo; ?></a> / <?php echo $galeria['nome']; ?></h1>
		<a id="engadir-fotos-boton" class="boton" href="#">Engadir fotos...</a>
	</header>

	<div id="engadir-fotos-input" class="zona-dragdrop hidden" data-url="<?php echo $this->App->url; ?>subir-fotos/<?php echo $galeria['nome']; ?>">
		<div id="mensaxe">Arrastra aqui as fotos que queiras subir
			<p>Só imaxes (jpg) e cun máximo de <?php echo $max; ?>Mb por imaxe.</p>
		</div>

		<progress max="1" class="hidden"></progress>

		<ul id="engadir-fotos-miniaturas"></ul>
	</div>

	<ul class="videos">
		<?php foreach ($videos as $video): ?>
		<li>
			<video width="500" controls>
				<source src="<?php echo $this->App->assetsUrl.'fotos/'.$galeria['nome'].'/'.$video['mp4']; ?>">

				<?php if (isset($video['ogv'])): ?>
				<source src="<?php echo $this->App->assetsUrl.'fotos/'.$galeria['nome'].'/'.$video['ogv']; ?>">
				<?php endif; ?>

				<?php if (isset($video['webm'])): ?>
				<source src="<?php echo $this->App->assetsUrl.'fotos/'.$galeria['nome'].'/'.$video['webm']; ?>">
				<?php endif; ?>
			</video>
		</li>
		<?php endforeach; ?>
	</ul>

	<ul class="fotos">
		<?php foreach ($fotos as $k => $foto): ?>
		<li contextmenu="cmenu_<?php echo $k; ?>">
			<a href="<?php echo $this->App->assetsUrl.'fotos/'.$galeria['nome'].'/'.$foto['file']; ?>" class="fancybox" rel="galeria">
				<img src="<?php echo $this->App->assetsUrl.'cache/fotos/'.$galeria['nome'].'/'.$foto['file'].'/resize,0,200.jpg'; ?>" alt="Foto">
			</a>

			<menu type="context" id="cmenu_<?php echo $k; ?>">
				<menuitem label="Xirar 90º cara a dereita" onclick="rotateImg('<?php echo $foto['file']; ?>', <?php echo $k ?>);"></menuitem>
				<menuitem label="Eliminar esta foto" onclick="deleteImg('<?php echo $foto['file']; ?>', <?php echo $k ?>);"></menuitem>
			</menu>
		</li>
		<?php endforeach; ?>
	</ul>
</section>