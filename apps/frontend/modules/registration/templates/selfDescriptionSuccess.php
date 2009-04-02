<?php use_helper('Object', 'dtForm', 'fillIn') ?>

<?php echo __('Self Description introduction') ?>
<?php echo __('Self Description reminder') ?>
<?php echo __('Self Description note') ?>
<?php echo form_tag('registration/selfDescription', array('id' => 'self_desc_form')) ?>
    <?php $i=0; ?>
    <?php foreach ($questions as $question): ?>
      <?php include_partial('editProfile/question_title', array('question' => $question, 'i' => $i++)); ?>
      <?php ( $sf_request->hasError('answers['.$question->getId().']') ) ? $style = "form_err" : $style = " "; ?>
      <div class="<?php echo $style ?>">
      <?php if( $question->getType() == 'radio' && isset($answers[$question->getId()]) ): ?>
        <?php include_partial('editProfile/question_type_radio', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
        <?php include_partial('editProfile/question_other', array('question' => $question, 'member_answers' => $member_answers) ); ?>
      <?php elseif( $question->getType() == 'select' && isset($answers[$question->getId()]) ): ?>
        <?php include_partial('editProfile/question_type_select', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
        <?php include_partial('editProfile/question_other', array('question' => $question, 'member_answers' => $member_answers) ); ?>
      <?php elseif( $question->getType() == 'native_lang' ): ?>
        <?php echo pr_select_language_tag('answers['. $question->getid() .']', ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getCustom() : null ) ?><br />
        <?php include_partial('editProfile/question_other_checkbox', array('question' => $question, 'member_answers' => $member_answers) ); ?>
      <?php elseif( $question->getType() == 'age' ): ?>
        <?php include_partial('editProfile/question_type_age', array('member' => $member, 'question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
        <?php include_partial('editProfile/question_other', array('question' => $question, 'member_answers' => $member_answers) ); ?>
      <?php elseif( $question->getType() == 'other_langs' ): ?>
        <?php include_partial('editProfile/question_type_other_langs', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
        <?php include_partial('editProfile/question_other_checkbox', array('question' => $question, 'member_answers' => $member_answers) ); ?>
      <?php endif; ?>
      </div>
    <?php endforeach; ?>
        
    <?php echo submit_tag(__('Save and Continue'), array('class' => 'button')) ?>
</form>
<br />
<?php echo __('Self Description note') ?>