<?php if( !is_null($question->getOther()) ): ?>
    <?php echo checkbox_tag('others['. $question->getid() .']', 'other', fillIn( 'others['. $question->getid() .']', 'r', false, isset($member_answers[$question->getId()]) && !is_null($member_answers[$question->getId()]->getOther()) ), array('class' => 'zodiac') ) ?>
    <?php echo pr_label_for('answers['. $question->getid() .'][other]', $question->getOther()) ?><br />
<?php endif; ?>
