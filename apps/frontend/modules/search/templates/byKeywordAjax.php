<?php if( isset($pager) ): ?>
  <?php if( $pager->getNbResults() > 0): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/byKeyword')); ?>
  <?php else: ?>
    <div class="msg_error text-center"><?php echo __('No results found - by keyword') ?></div>
  <?php endif; ?>
<?php endif; ?>