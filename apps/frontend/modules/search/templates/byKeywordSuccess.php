<?php include_partial('searchTypes'); ?>

<form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box" class="public_matches">
<p class="search_p search_keyword">
    <label for="filters[keyword]"><?php echo __('Enter keyword') ?></label>
    <?php echo input_tag('filters[keyword]', (isset($filters['keyword'])) ? $filters['keyword'] : null, array('class' => 'input_text_width')) ?>
</p>
<?php include_partial('filters', array('filters' => $filters)); ?>

<br />
<?php if( isset($filters['keyword']) && strlen($filters['keyword']) > 3): ?>
    <p><?php echo __('Profiles with a "%KEYWORD%" keyword.', array('%KEYWORD%' => $filters['keyword']) ) ?></p>
<?php endif; ?>

<?php if( isset($pager) ): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/byKeyword')); ?>
<?php endif; ?>