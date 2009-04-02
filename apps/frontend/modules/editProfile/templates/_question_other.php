<?php $class = ($sf_request->hasErrors() && $sf_request->hasError('answers['. $question->getId() .']')) ? 'radio_error' : 'radio'; ?>
<?php if( !is_null($question->getOther()) ): ?>
    <?php echo radiobutton_tag('answers['. $question->getid() .']', 'other', fillIn( 'answers['. $question->getid() .']', 'r', false, isset($member_answers[$question->getId()]) && !is_null($member_answers[$question->getId()]->getOther()) ), array('class' => $class) ) ?>
    <?php echo pr_label_for('answers['. $question->getid() .'][other]', __($question->getOther(ESC_RAW))) ?><br />
    <?php echo input_tag('others['. $question->getid() .']', ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getOther() : null ) ?>
<?php endif; ?>