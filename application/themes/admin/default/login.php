<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Posecom</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo loadAsset('css/bootstrap.css') ?>"> 
	    <link rel="stylesheet" href="<?php echo loadAsset('css/form-elements.css') ?>">
        <link rel="stylesheet" href="<?php echo loadAsset('css/log_style.css') ?>">
        <script src="<?php echo loadAsset('js/jquery-1.11.1.min.js') ?>"></script>
        <script src="<?php echo loadAsset('js/jquery.backstretch.min.js') ?>"></script>
        <script src="<?php echo loadAsset('js/scripts.js') ?>"></script>
    </head>
    <body>
        <!-- Top content -->
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    
                    <?php echo $template['partials']['flash_messages'] ?>
                    <?php echo $template['body'] ?>
                    
                </div>
            </div>
        </div>
    </body>
</html>