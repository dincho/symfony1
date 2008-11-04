<?php include_partial('searchTypes'); ?>

<?php echo __('You are using Reverse Search. These are profiles whose search criteria you (or actually your %LINK_TO_SELF_DESCRIPTION%, to be precise) meet best.', 
array('%LINK_TO_SELF_DESCRIPTION%' => link_to(__('self-description'), 'editProfile/selfDescription', 'class=sec_link'))) ?>
<form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box" class="public_matches">
<?php include_partial('filters', array('filters' => $filters)); ?>

<?php if( isset($pager) ): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/reverse')); ?>
<?php endif; ?>