<!DOCTYPE html>
<html>
    <head>
        <title>Public Solution Apps</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="<?php echo assets('jquery-1.10.2.min.js', ASSET_TYPE_JS); ?>"></script>
        <link href="<?php echo assets('kendoui/styles/kendo.common.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo assets('kendoui/styles/kendo.default.min.css'); ?>" rel="stylesheet">
        <script src="<?php echo assets('kendoui/js/kendo.all.min.js'); ?>"></script>
    </head>
    <body>
        <div> <?php echo isset($grid) ? $grid : ''; ?> </div>
        <hr>
        <div> <?php echo isset($datepicker) ? '' : ''; ?> </div>
    </body>
</html>