<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body>
    <div id="wrap">
        <div id="left">
          <?php include_component_slot('sidebar', array('top_menu_selected' => @$top_menu_selected, 'left_menu_selected' => @$left_menu_selected )); ?>

          <?php if($sf_user->isAuthenticated()): ?>
              <div id="login_info">
                <p>Hi <?php echo $sf_user->getUsername() . '&nbsp;' . link_to('(My Account)', 'users/myAccount') ?><br />Last Login: <?php echo $sf_user->getLastLogin() ?></p>
                <?php echo button_to('Logout', 'system/logout', 'id=logout_button') ?>
              </div>
          <?php endif; ?>
        </div>

        <?php include_component('system', 'topMenu', array('top_menu_selected' => @$top_menu_selected, 'left_menu_selected' => @$left_menu_selected )); ?>

        <div id="content">
            <?php include_component('system', 'breadcrumb'); ?>
            <div id="msg_container">
                <?php include_component('system', 'messages') ?>
            </div>
            <?php echo $sf_data->getRaw('sf_content') ?>
        </div>
    </div>
    
    <br style="clear: left;" />
    
</body>
</html>
