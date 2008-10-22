<?php include_partial('searchTypes'); ?>

Profiles sorted by most recent. Change filter settings if needed.
<?php include_partial('filters', array('filters' => $filters)); ?>

<?php if( isset($pager) ): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/mostRecent')); ?>
<?php endif; ?>