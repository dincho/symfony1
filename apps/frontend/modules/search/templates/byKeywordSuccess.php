<?php include_partial('searchTypes'); ?>

<form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box">
<p class="search_p search_keyword">
    <label for="filters[keyword]"><?php echo __('Enter keyword') ?></label>
    <?php echo input_tag('filters[keyword]', (isset($filters['keyword'])) ? $filters['keyword'] : null, array('class' => 'input_text_width')) ?>
</p>
<?php include_partial('filters', array('filters' => $filters)); ?>
<br />

<?php if( isset($pager) ): ?>
  <?php if( $pager->getNbResults() > 0): ?>
    <p><?php echo __('Profiles with a "%KEYWORD%" keyword.', array('%KEYWORD%' => $filters['keyword']) ) ?></p>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/byKeyword')); ?>
  <?php else: ?>
    <div class="msg_error text-center"><?php echo __('No results found - by keyword') ?></div>
  <?php endif; ?>
<?php endif; ?>
