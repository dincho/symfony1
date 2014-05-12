<div class="title">
    <?php echo ++$i; ?>. <?php echo __($question->getTitle(ESC_RAW)) ?>  <?php echo (($question->getIsRequired()) ? '<span style="color:red;">*</span>' : '') ?>
    <span>
    <?php if($question->getType() == 'age'): ?>
        <?php echo __('(If you\'re not 19 or older, you are not allowed to be here - you must leave now!)') ?>
    <?php else: ?>
        <?php echo ($question->getIsRequired()) ? __('(select one)') : __('(optional, select one)')?>
    <?php endif; ?>
    <?php if( $question->getType() == 'other_langs' ): ?>
        <?php echo link_to_function(__('add'), 'if (hidden_lang_ids.length > 0) { hidden_lang_ids.sort(); $("lang_container_" + hidden_lang_ids.shift()).show(); }', array('class' => 'sec_link'));?>
    <?php endif; ?>
    </span>
</div>
