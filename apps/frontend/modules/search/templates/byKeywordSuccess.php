<?php include_partial('searchTypes'); ?>

<p class="search_p">
    <label for="key">Enter keyword, e.g. "Ania" or "bank"</label><input type="text" id="key" class="input_text_width" />
</p>
<?php include_partial('filters', array('filters' => $filters)); ?>

<?php if( isset($pager) ): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/byKeyword')); ?>
<?php endif; ?>