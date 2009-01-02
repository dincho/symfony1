<?php include_partial('searchTypes'); ?>

<?php if($has_criteria): ?>
    <form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box" class="public_matches">
    <?php include_partial('filters', array('filters' => $filters)); ?>
    
    <?php if( isset($pager) ): ?>
        <?php include_partial('results', array('pager' => $pager, 'route' => 'search/criteria')); ?>
    <?php endif; ?>
<?php else: ?>
    <?php echo __('To use Search by Criteria you obviously need to set up your search criteria first.') ?>    
<?php endif; ?>