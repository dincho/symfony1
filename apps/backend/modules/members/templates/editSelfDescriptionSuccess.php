<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('members/editSelfDescription', 'class=form id=self_description_form') ?>
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  <div class="legend">Self-Description</div>
  <fieldset class="form_fields">
    <?php $i=1; ?>
    <label class="full_row" for="birth_day"><?php echo $i ?>. What`s your birthday?</label>
    <div class="date_tag_wrap">
      <?php echo object_input_date_tag($member, 'getBirthDay', array('date_seperator' => '&nbsp;', 
                                                                     'order' => array('m', 'd', 'y'), 
                                                                     'year_start' => date('Y') - 90,
                                                                     'year_end' => date('Y') - 18,
                                                                     'use_month_numbers' => true,
                                                                      )) ?>
    </div>
    <?php echo object_checkbox_tag($member, 'getDontDisplayZodiac', 'class=checkbox') ?>
    <label for="dont_display_zodiac">Don`t display my zodiac sign</label><br />
    
    <?php /* ?>
    <?php foreach ($questions as $question): ?>
      <label class="full_row" for="answers"><?php echo ++$i; ?>. <?php echo $question->getTitle() ?></label>
      <?php if( $question->getType() == 'radio'): ?>
        <?php foreach ($question->getDescAnswers() as $answer): ?>
          <?php echo radiobutton_tag('answers['. $question->getid() .']', 
                                     $answer->getId(),
                                     ($question->getMemberDescAnswer() && $question->getMemberDescAnswer()->getId() == $answer->getId()) ? true : false,
                                     array('class' => 'radio') ) ?>
          <label for="<?php echo 'answers_'. $question->getId(). '_' .$answer->getId() ?>"><?php echo $answer->getTitle() ?></label><br />
        <?php endforeach; ?>
      <?php elseif( $question->getType() == 'select'): ?>
        <?php echo select_tag('answers['. $question->getid() .']',
                              objects_for_select($question->getDescAnswers(),
                              'getId', 
                              'getTitle',
                              ($question->getMemberDescAnswer() ) ? $question->getMemberDescAnswer()->getId() : null )) ?><br />
      <?php endif; ?>
      
    <?php endforeach; ?>
    */ ?>
    <?php foreach ($questions as $question): ?>
      <label class="full_row" for="answers"><?php echo ++$i; ?>. <?php echo $question->getTitle() ?> <span>(select one)</span></label>
      <?php if( $question->getType() == 'radio' && isset($answers[$question->getId()]) ): ?>
        <?php foreach ($answers[$question->getId()] as $answer): ?>
          <?php echo radiobutton_tag('answers['. $question->getid() .']', 
                                     $answer->getId(),
                                     ( isset($member_answers[$question->getId()]) && $member_answers[$question->getId()]->getDescAnswerId() == $answer->getId()) ? true : false,
                                     array('class' => 'radio') ) ?>
          <label for="<?php echo 'answers_'. $question->getId(). '_' .$answer->getId() ?>"><?php echo html_entity_decode($answer->getTitle(), null, 'utf-8') ?></label><br />
        <?php endforeach; ?>
      <?php elseif( $question->getType() == 'select' && isset($answers[$question->getId()]) ): ?>
        <?php echo select_tag('answers['. $question->getid() .']',
                              objects_for_select($answers[$question->getId()],
                              'getId', 
                              'getTitle',
                              ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getDescAnswerId() : null )) ?><br />
      <?php elseif( $question->getType() == 'native_lang' ): ?>
        <?php echo pr_select_language_tag('answers['. $question->getid() .']',
                              $member->getLanguage() ) ?><br />
      <?php elseif( $question->getType() == 'other_langs' ): ?>
        <?php $lang_answers = ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getOtherLangs() : array() ?>
        <?php for($n=1; $n<5; $n++): ?>
            <?php echo pr_select_language_tag('answers['. $question->getid() .']['. $n.']',
                                  (isset($lang_answers[$n])) ? $lang_answers[$n]['lang'] : null, array('include_custom' => 'Select Language') ) ?>
            <?php echo pr_select_language_level('answers['. $question->getid() .'][lang_levels]['. $n.']', (isset($lang_answers[$n])) ?  $lang_answers[$n]['level'] : null, array('class' => 'language_level', 'include_custom' => 'Select Level')) ?>                 
            <br />
        <?php endfor; ?>
      <?php endif; ?>
      
    <?php endforeach; ?>    
    
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editRegistration?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

<?php include_partial('members/bottomMenu', array('member_id' => $member->getId())); ?>