<?php if($has_criteria): ?>
    <?php if( isset($pager) && $pager->getNbResults() > 0 ): ?>
        <?php include_partial('results', array('pager' => $pager, 'route' => 'search/criteria')); ?>
    <?php else: ?>
        <div class="msg_error text-center"><?php echo __('No results found - by criteria') ?></div>
    <?php endif; ?>
<?php else: ?>
    <?php echo __('To use Search by Criteria you obviously need to set up your search criteria first.') ?>    
<?php endif; ?>