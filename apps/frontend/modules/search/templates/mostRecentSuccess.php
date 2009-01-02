<?php include_partial('searchTypes'); ?>

<?php echo __('Profiles sorted by most recent. Change filter settings if needed.') ?>

<form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box" class="public_matches">
<?php include_partial('filters', array('filters' => $filters)); ?>

<?php if( isset($pager) ): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/mostRecent')); ?>
<?php endif; ?>