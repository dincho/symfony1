<?php if( !is_null($question->getOther()) ): ?>
    <?php echo checkbox_tag('answers['. $question->getid() .']', 'other', fillIn( 'answers['. $question->getid() .']', 'r', false, isset($member_answers[$question->getId()]) && !is_null($member_answers[$question->getId()]->getOther()) ), 
                            array('class' => 'zodiac', 'id' => 'others_check_' . $question->getId()) ) ?>
    <?php echo pr_label_for('others_check_' . $question->getId(), __($question->getOther(ESC_RAW))) ?><br />
    <?php echo input_tag('others['. $question->getid() .']', ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getOther() : null, array('maxlength' => 35) ) ?>
<?php endif; ?>