<?php if( $sf_user->isAuthenticated()): ?>
  <div id="breadcrumb">
    <?php $sf_user->getBC()->draw(); ?>
  </div>
<?php endif; ?>
