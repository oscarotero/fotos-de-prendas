<!doctype html>

<html>
	<head>
		<meta charset="utf-8">

		<title><?php echo $titulo; ?></title>

		<link rel="stylesheet" href="<?php echo $this->app->getPublicUrl('components/csans/csans.css'); ?>">
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,900' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo $this->app->getPublicUrl('components/fancybox/source/jquery.fancybox.css'); ?>">
		<link rel="stylesheet" href="<?php echo $this->app->getPublicUrl('assets/estilos.min.css'); ?>">

		<script src="<?php echo $this->app->getPublicUrl('components/jquery/dist/jquery.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $this->app->getPublicUrl('components/fancybox/source/jquery.fancybox.pack.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $this->app->getPublicUrl('components/jquery-filedrop/jquery.filedrop.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $this->app->getPublicUrl('assets/scripts.js'); ?>" type="text/javascript" charset="utf-8"></script>
	</head>

	<body>
		<?php echo $this->render('body'); ?>
	</body>
</html>