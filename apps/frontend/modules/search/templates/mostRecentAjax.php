<?php if( isset($pager) && $pager->getNbResults() > 0 ): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/mostRecent')); ?>
<?php else: ?>
    <div class="msg_error text-center"><?php echo __('No results found - most recent') ?></div>
<?php endif; ?>