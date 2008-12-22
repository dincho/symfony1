<label class="full_row">
    <?php echo ++$i; ?>. <?php echo $question->getTitle() ?> 
    <span>
    <?php if($question->getType() == 'age'): ?>
        <?php echo '(If you\'re not 19 or older, you are not allowed to be here - you must leave now!)' ?>
    <?php else: ?>
        <?php echo ($question->getIsRequired()) ? '(select one)' : '(optional, select one)'?>
    <?php endif; ?>
    </span>
</label>