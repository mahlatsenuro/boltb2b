<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title><?php echo $template['title'] ?></title>
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php echo $template['metadata'] ?>
    <link href="https://fonts.googleapis.com/css?family=Fjalla+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo loadAsset('css/bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo loadAsset('css/normalize.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo loadAsset('css/unifilter.css'); ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo loadAsset('css/style.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo loadAsset('css/responsive.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo loadAsset('css/animate.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo loadAsset('css/frontend.css', 'common'); ?>">
    <?php echo $template['css'] ?>
    <script src="<?php echo loadAsset('js/jquery.min.js') ?>"></script>
</head>
<body class="header_sticky header-style-2 topbar-style-2 topbar-width-94 topbar-divider has-menu-extra">
	<div class="boxed">
		<?php echo $template['partials']['header'] ?>
	    <?php echo $template['partials']['flash'] ?>
	    <?php echo $template['body'] ?>
	    <?php echo $template['partials']['footer'] ?>
    </div>
    <script src="<?php echo loadAsset('js/frontend.js', 'common') ?>"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js'></script>
    <script src="<?php echo loadAsset('js/masonry.min.js') ?>"></script>
    <script src="<?php echo loadAsset('js/imagesloaded.min.js') ?>"></script>
    <script src="<?php echo loadAsset('js/jquery.unifilter.min.js') ?>"></script>
    <script src="<?php echo loadAsset('js/scripts.js') ?>"></script>
    <script src="<?php echo loadAsset('js/tether.min.js') ?>"></script>
    <script src="<?php echo loadAsset('js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo loadAsset('js/jquery.easing.js') ?>"></script>
    <script src="<?php echo loadAsset('js/images-loaded.js') ?>"></script>
    <script src="<?php echo loadAsset('js/jquery.isotope.min.js') ?>"></script>
    <script src="<?php echo loadAsset('js/magnific.popup.min.js') ?>"></script>
    <script src="<?php echo loadAsset('js/jquery.hoverdir.js') ?>"></script>
    <script src="<?php echo loadAsset('js/jquery.flexslider-min.js') ?>"></script>
    <script src="<?php echo loadAsset('js/equalize.min.js') ?>"></script>
    <script src="<?php echo loadAsset('js/main.js') ?>"></script>
    <?php echo $template['js'] ?>
</body>
</html>