<!doctype html>

<html>
	<head>
		<meta charset="utf-8">

		<title><?php echo $titulo; ?></title>

		<link rel="stylesheet" href="<?php echo $this->App->assetsUrl; ?>css/csans.css">
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,900' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo $this->App->assetsUrl; ?>../libs/fancybox/jquery.fancybox.css">
		<link rel="stylesheet" href="<?php echo $this->App->assetsUrl; ?>cache/css/estilos.css">

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $this->App->assetsUrl; ?>../libs/fancybox/jquery.fancybox.pack.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $this->App->assetsUrl; ?>../libs/jquery.filedrop/jquery.filedrop.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $this->App->assetsUrl; ?>js/scripts.js" type="text/javascript" charset="utf-8"></script>
	</head>

	<body>
		<?php echo $this->render('body', $data); ?>
	</body>
</html>