<?php $class = ($sf_request->hasErrors() && $sf_request->hasError('answers['. $question->getId() .']')) ? 'radio_error' : 'radio'; ?>
<?php foreach ($answers[$question->getId()] as $answer): ?>
  <?php echo radiobutton_tag('answers['. $question->getId() .']',
                             $answer->getId(),
                             fillIn('answers['. $question->getId() .']', 'r', false, isset($member_answers[$question->getId()]) && $member_answers[$question->getId()]->getDescAnswerId() == $answer->getId()),
                             array('class' => $class) ) ?>
  <label for="<?php echo 'answers_'. $question->getId(). '_' .$answer->getId() ?>"><?php echo __($answer->getTitle(ESC_RAW)) ?></label><br />
<?php endforeach; ?>
