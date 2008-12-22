<?php foreach ($answers[$question->getId()] as $answer): ?>
  <?php echo radiobutton_tag('answers['. $question->getId() .']', 
                             $answer->getId(),
                             fillIn('answers['. $question->getId() .']', 'r', false, isset($member_answers[$question->getId()]) && $member_answers[$question->getId()]->getDescAnswerId() == $answer->getId()),
                             array('class' => 'radio') ) ?>
  <label for="<?php echo 'answers_'. $question->getId(). '_' .$answer->getId() ?>"><?php echo html_entity_decode($answer->getTitle(), null, 'utf-8') ?></label><br />
<?php endforeach; ?>