<?php if (file_exists(sfConfig::get('sf_web_dir').'/favicons/'.$_SERVER['HTTP_HOST'].'.ico')): ?>
  <?php echo '<link rel="shortcut icon" href="/favicons/'.$_SERVER['HTTP_HOST'].'.ico" />' ?>
<?php else: ?>
  <link rel="shortcut icon" href="/favicon.ico" />
<?php endif; ?>