<?php if( !is_null($question->getOther()) ): ?>
    <?php echo checkbox_tag('answers['. $question->getid() .']', 'other', fillIn( 'answers['. $question->getid() .']', 'r', false, isset($member_answers[$question->getId()]) && !is_null($member_answers[$question->getId()]->getOther()) ), array('class' => 'zodiac') ) ?>
    <?php echo pr_label_for('answers['. $question->getid() .'][other]', __($question->getOther(ESC_RAW))) ?><br />
    <?php echo input_tag('others['. $question->getid() .']', ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getOther() : null ) ?>
<?php endif; ?>