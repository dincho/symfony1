<?php include_partial('searchTypes'); ?>

<?php echo __('You are using Reverse Search. These are profiles whose search criteria you (or actually your self-description, to be precise) meet best.') ?>

<form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box">
<?php include_partial('filters', array('filters' => $filters)); ?>

<?php if( isset($pager) && $pager->getNbResults() > 0 ): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/reverse')); ?>
<?php else: ?>
    <div class="msg_error text-center"><?php echo __('No results found - reverse') ?></div>
<?php endif; ?>
