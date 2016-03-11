<!doctype html>

<html>
	<head>
		<meta charset="utf-8">

		<title><?php echo $title; ?></title>

		<link rel="stylesheet" href="<?php echo $app->getUrl('css/estilos.css'); ?>">

		<script src="<?php echo $app->getUrl('js/main.js'); ?>" type="text/javascript" charset="utf-8"></script>
	</head>

	<body>
		<?= $this->section('content'); ?>
	</body>
</html>