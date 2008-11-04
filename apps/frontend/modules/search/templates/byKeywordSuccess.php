<?php include_partial('searchTypes'); ?>

<form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box">
<p class="search_p search_keyword">
    <label for="keyword"><?php echo __('Enter keyword, e.g. "Ania" or "bank"') ?></label>
    <input name="keyword" type="text" id="keyword" class="input_text_width" />
</p>
<?php include_partial('filters', array('filters' => $filters)); ?>

<br />
<?php if(strlen($sf_request->getParameter('keyword')) > 3): ?>
    <p><?php echo __('Profiles with a "%KEYWORD%" keyword.', array('%KEYWORD%' => $sf_request->getParameter('keyword'))) ?></p>
<?php endif; ?>

<?php if( isset($pager) ): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/byKeyword')); ?>
<?php endif; ?>