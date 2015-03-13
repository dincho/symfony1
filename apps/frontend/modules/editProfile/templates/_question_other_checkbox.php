<?php if( !is_null($question->getOther()) ): ?>
    <?php echo checkbox_tag('others['. $question->getid() .']', 'other', fillIn( 'others['. $question->getid() .']', 'r', false, isset($member_answers[$question->getId()]) && !is_null($member_answers[$question->getId()]->getOther()) ),
                            array('class' => 'zodiac', 'id' => 'others_check_' . $question->getId()) ) ?>
    <?php echo pr_label_for('others_check_' . $question->getId(), __($question->getOther(ESC_RAW))) ?><br />
<?php endif; ?>
