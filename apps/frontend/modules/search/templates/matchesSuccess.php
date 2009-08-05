<?php include_partial('searchTypes'); ?>

<?php if($has_criteria): ?>
    <?php echo __('Profiles sorted by match percentage.') ?>
    <form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box">
    <?php include_partial('filters', array('filters' => $filters)); ?>
    
    <?php if( isset($pager) ): ?>
        <?php include_partial('results', array('pager' => $pager, 'route' => 'search/matches')); ?>
    <?php endif; ?>

<?php else: ?>
    <?php echo __('To use Matches you obviously need to set up your search criteria first.') ?>    
<?php endif; ?>