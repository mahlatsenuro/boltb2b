<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" type="image/png" href="<?php echo loadAsset('images/'.$this->config->item('fav_icon'), true) ?>"/> 
    
    <title><?php echo $template['title'] ?></title>
    <link href="<?php echo loadAsset( 'css/bootstrap.css' ); ?>" rel="stylesheet" />
    <link href="<?php echo loadAsset( 'css/font-awesome.min.css' ); ?>" rel="stylesheet" />
    <link href="<?php echo loadAsset( 'css/custom.css' ); ?>" rel="stylesheet" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <?php echo $template['css'] ?>
    <script src="<?php echo loadAsset( 'js/jquery-1.11.1.min.js' ); ?>"></script>
    <script src="<?php echo loadAsset( 'js/bootstrap.min.js' ); ?>"></script>
    <script src="<?php echo loadAsset( 'js/jquery.metisMenu.js' ); ?>"></script>
    <script src="<?php echo loadAsset( 'js/custom.js' ); ?>"></script>
    <?php echo $template['metadata'] ?>
    <?php echo $template['js'] ?>
</head>
<body> 
    <div id="wrapper">

        <?php echo $template['partials']['header'] ?>
        <?php echo $template['partials']['sidebar'] ?>
        <div id="page-wrapper" >
            <?php echo $template['partials']['flash'] ?>
            <?php echo $template['body'] ?>
        </div>
    </div>
    <script type="text/javascript">
        $("document").ready(function(){
            $(".panel-body .nav-tabs li a").click(function(e){
                e.preventDefault();
                var link = $(this).attr('href');
                $('<input>').attr({
                    type: 'hidden',
                    id: 'redirect',
                    name: 'redirect',
                    value: link
                }).appendTo('form.form-new');

                $("form.form-new").submit();
            });
        });
    </script>
</body>
</html>
