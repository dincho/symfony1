<?php $class = ($sf_request->hasErrors() && $sf_request->hasError('answers['. $question->getId() .']')) ? 'title error' : 'title'; ?>
<label class="<?php echo $class; ?>">
    <?php echo ++$i; ?>. <?php echo $question->getTitle() ?> 
    <span>
    <?php if($question->getType() == 'age'): ?>
        <?php echo __('(If you\'re not 19 or older, you are not allowed to be here - you must leave now!)') ?>
    <?php else: ?>
        <?php echo ($question->getIsRequired()) ? __('(select one)') : __('(optional, select one)')?>
    <?php endif; ?>
    </span>
</label>