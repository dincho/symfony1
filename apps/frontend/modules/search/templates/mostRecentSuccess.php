<?php include_partial('searchTypes'); ?>

<?php echo __('Profiles sorted by most recent. Change filter settings if needed.') ?>

<form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box">
<?php include_partial('filters', array('filters' => $filters)); ?>

<?php if( isset($pager) && $pager->getNbResults() > 0 ): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/mostRecent')); ?>
<?php else: ?>
    <div class="msg_error text-center"><?php echo __('No results found - most recent') ?></div>
<?php endif; ?>