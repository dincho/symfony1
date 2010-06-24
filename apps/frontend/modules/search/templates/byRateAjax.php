<?php if( isset($pager) && $pager->getNbResults() > 0 ): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/byRate')); ?>
<?php else: ?>
    <div class="msg_error text-center"><?php echo __('You have not rated anyone.') ?></div>
<?php endif; ?>
