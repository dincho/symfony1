<?php use_helper('Object', 'dtForm', 'fillIn') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('members/editSelfDescription', 'class=form id=self_description_form') ?>
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  <div class="legend">Self-Description</div>
  <fieldset class="form_fields">
    <?php $i=0; ?>
    <?php foreach ($questions as $question): ?>
      <?php include_partial('members/self_description/question_title', array('question' => $question, 'i' => $i++)); ?>
      <?php if( $question->getType() == 'radio' && isset($answers[$question->getId()]) ): ?>
        <?php include_partial('members/self_description/question_type_radio', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
      <?php elseif( $question->getType() == 'select' && isset($answers[$question->getId()]) ): ?>
        <?php include_partial('members/self_description/question_type_select', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
      <?php elseif( $question->getType() == 'native_lang' ): ?>
        <?php echo pr_select_language_tag('answers['. $question->getid() .']', ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getCustom() : null) ?><br />
      <?php elseif( $question->getType() == 'age' ): ?>
        <?php include_partial('members/self_description/question_type_age', array('member' => $member, 'question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
      <?php elseif( $question->getType() == 'other_langs' ): ?>
        <?php include_partial('members/self_description/question_type_other_langs', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
      <?php endif; ?>
      <?php include_partial('members/self_description/question_other', array('question' => $question, 'member_answers' => $member_answers) ); ?>
    <?php endforeach; ?> 
    
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editRegistration?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

<?php include_partial('members/bottomMenu', array('member_id' => $member->getId())); ?>