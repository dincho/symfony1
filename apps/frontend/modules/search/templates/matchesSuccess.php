<?php include_partial('searchTypes'); ?>

<?php if($has_criteria): ?>
    <?php echo __('Profiles sorted by match percentage.') ?>
    <form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box">
    <?php include_partial('filters', array('filters' => $filters)); ?>

    <?php if( isset($pager) && $pager->getNbResults() > 0 ): ?>
        <?php include_partial('results', array('pager' => $pager, 'route' => 'search/matches')); ?>
    <?php else: ?>
        <div class="msg_error text-center"><?php echo __('No results found - matches') ?></div>
    <?php endif; ?>

<?php else: ?>
    <?php echo __('To use Matches you obviously need to set up your search criteria first.') ?>
<?php endif; ?>
