<!DOCTYPE html>
<html>
    <head>
        <title>Login CP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="<?php echo assets('bootstrap.min.css', ASSET_TYPE_CSS); ?>" rel="stylesheet" media="screen">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script type="text/javascript" src="<?php echo assets('jquery-1.10.2.min.js', ASSET_TYPE_JS); ?>"></script>
        <script type="text/javascript" src="<?php echo assets('bootstrap.min.js', ASSET_TYPE_JS); ?>"></script>
        <script type="text/javascript">
            $(function(){
                $('.captcha_img').on('click', function(e){
                    e.preventDefault();
                    i = $(this);
                    url = i.attr('src');
                    i.attr('src', '');
                    i.attr('src', url)
                });
            });
        </script>
    </head>
    <body>
        <?php echo $yield; ?>
    </body>
</html>