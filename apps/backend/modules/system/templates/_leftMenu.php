<ul id="left_menu">
<?php if($sf_user->isAuthenticated()): ?>
  <?php $context = sfContext::getInstance(); ?>
  <?php foreach ($menu as $item): ?>
    <?php if( $context->getModuleName() . '/' . $context->getActionName() == $item['uri'] || $left_menu_selected == $item['title']): ?>
      <li class="selected"><?php echo $item['title'] ?></li>
    <?php else: ?>
      <li><?php echo link_to($item['title'], $item['uri']) ?></li>
    <?php endif; ?>
  <?php endforeach; ?>
  <?php endif; ?>
  <li></li> <?php //blank li for HTML validation ?>
</ul>
