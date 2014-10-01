<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>
<?php require_once(dirname(__FILE__).'/_favicon.inc.php'); ?>

</head>

<body class="window">
    <div id="msg_container">
        <?php if( $sf_data->get('sf_flash')->has('msg_error') ||
                  $sf_data->get('sf_flash')->has('msg_warning') ||
                  $sf_data->get('sf_flash')->has('msg_ok') ||
                  $sf_data->get('sf_flash')->has('msg_info') ): ?>
            <?php include_partial('content/messages'); ?>
        <?php endif; ?>
        <?php include_partial('content/formErrors'); ?>
    </div>

    <div id="secondary_container">
        <?php echo $sf_data->getRaw('sf_content') ?>
    </div>
</body>
</html>
