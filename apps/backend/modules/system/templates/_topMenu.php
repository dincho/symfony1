<ul id="top_menu">
<?php if($sf_user->isAuthenticated()): ?>
  <?php foreach ($menu as $item): ?>
    <?php if( $top_menu_selected == substr($item['uri'], 0, strrpos($item['uri'], '/'))): ?>
      <li class="selected"><?php echo $item['title'] ?></li>
    <?php else: ?>
      <li><?php echo link_to($item['title'], $item['uri']) ?></li>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>
</ul>
