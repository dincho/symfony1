<label class="full_row">
    <?php echo ++$i; ?>. <?php echo $question->getTitle() ?>
    <span>
    <?php if($question->getType() == 'age'): ?>
        <?php echo '(If you\'re not 19 or older, you are not allowed to be here - you must leave now!)' ?>
    <?php else: ?>
        <?php echo ($question->getIsRequired()) ? '(select one)' : '(optional, select one)'?>
    <?php endif; ?>
    <?php if( $question->getType() == 'other_langs' ): ?>
        <?php echo link_to_function('add', 'if (hidden_lang_ids.length > 0) { hidden_lang_ids.sort(); $("lang_container_" + hidden_lang_ids.shift()).show(); }', array('class' => 'sec_link'));?>
    <?php endif; ?>
    </span>
</label>
