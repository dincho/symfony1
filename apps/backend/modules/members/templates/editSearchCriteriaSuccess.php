<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('members/editSearchCriteria', 'class=form id=self_description_form') ?>
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  
  <div class="legend">Search Criteria</div>
  <fieldset class="form_fields">
    <?php $i=1; ?>
    <label class="full_row" for="birth_day"><?php echo $i ?>. You`re looking for someone aged:</label><br />
    
    <?php foreach ($questions as $question): ?>
      <label class="full_row" for="answers"><?php echo ++$i; ?>. <?php echo $question->getSearchTitle() ?>:</label>
      <?php if( $question->getType() == 'radio'): ?>
        <?php foreach ($question->getDescAnswers() as $answer): ?>
          <?php echo checkbox_tag('answers[' . $question->getId() . '][]', $answer->getId(), in_array($answer->getId(), $question->getSearchCritDescAnswers())? true:false, 'class=checkbox') ?>
          <label for="<?php echo 'answers_'. $question->getId(). '_' .$answer->getId() ?>"><?php echo $answer->getSearchTitle() ?></label><br />
        <?php endforeach; ?>
      <?php elseif( $question->getType() == 'select'): ?>
        <?php echo select_tag('answers['. $question->getid() .'][from]',
                              objects_for_select($question->getDescAnswers(),
                              'getId', 
                              'getTitle', $question->getSearchCritDescFirstAnswer()
                               )) ?>
        <?php echo select_tag('answers['. $question->getid() .'][to]',
                              objects_for_select($question->getDescAnswers(),
                              'getId', 
                              'getTitle', $question->getSearchCritDescLastAnswer()
                               )) ?><br />
      <?php endif; ?>
      <?php echo select_tag('weights[' . $question->getId() .']', objects_for_select(MatchWeightPeer::doSelect(new Criteria()), 'getId', 'getTitle', $question->getSearchCritDesc()->getMatchWeightId())) ?><br />
    <?php endforeach; ?>
    
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editSearchCriteria?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

<?php include_partial('members/bottomMenu', array('member_id' => $member->getId())); ?>