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
		<h1><a href="<?php echo $this->App->url; ?>"><?php echo $this->Controller->titulo; ?></a> / <?php echo $galeria['nome']; ?></h1>
		<a id="engadir-fotos-boton" class="boton" href="#">Engadir fotos...</a>
	</header>

	<div id="engadir-fotos-input" class="zona-dragdrop hidden" data-url="<?php echo $this->App->url; ?>subir-fotos/<?php echo $galeria['nome']; ?>">
		Arrastra aqui as fotos que queiras subir
		<p>Só imaxes (jpg) e cun máximo <?php echo $max; ?>Mb por imaxe.</p>

		<progress max="100" class="hidden"></progress>

		<ul id="engadir-fotos-miniaturas"></ul>
	</div>

	<ul class="fotos">
		<?php foreach ($fotos as $k => $foto): ?>
		<li contextmenu="cmenu_<?php echo $k; ?>">
			<a href="<?php echo $this->App->assetsUrl.'fotos/'.$galeria['nome'].'/'.$foto; ?>" class="fancybox" rel="galeria">
				<img src="<?php echo $this->App->assetsUrl.'cache/fotos/'.$galeria['nome'].'/'.$foto.'/resize,300.jpg'; ?>" alt="Foto">
			</a>

			<menu type="context" id="cmenu_<?php echo $k; ?>">
				<menuitem label="Xirar 90º cara a dereita" onclick="rotate('<?php echo $foto; ?>', <?php echo $k ?>);"></menuitem>
			</menu>
		</li>
		<?php endforeach; ?>
	</ul>
</section>