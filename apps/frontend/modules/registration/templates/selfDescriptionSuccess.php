<?php use_helper('Object', 'dtForm') ?>
<?php echo __('In order to match you with Polish singles we need to know a little about you.') ?><br />
<span class="public_reg_notice"><?php echo __('(Estimated time 120 seconds)') ?></span><br /><br />
<span><?php echo __('Reminder. If you\'re not 19 or older, you are not allowed to be here - you must leave now!') ?></span><br />
<span><?php echo __('Note: You will able to change this information later.') ?></span>
<?php echo form_tag('registration/selfDescription', array('id' => 'self_desc_form')) ?>
    <?php $i=0; ?>
    <?php foreach ($questions as $question): ?>
      <?php include_partial('editProfile/question_title', array('question' => $question, 'i' => $i++)); ?>
      <?php if( $question->getType() == 'radio' && isset($answers[$question->getId()]) ): ?>
        <?php include_partial('editProfile/question_type_radio', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
      <?php elseif( $question->getType() == 'select' && isset($answers[$question->getId()]) ): ?>
        <?php include_partial('editProfile/question_type_select', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
      <?php elseif( $question->getType() == 'native_lang' ): ?>
        <?php echo pr_select_language_tag('answers['. $question->getid() .']', $member->getLanguage() ) ?><br />
      <?php elseif( $question->getType() == 'age' ): ?>
        <?php include_partial('editProfile/question_type_age', array('member' => $member, 'question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
      <?php elseif( $question->getType() == 'other_langs' ): ?>
        <?php include_partial('editProfile/question_type_other_langs', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
      <?php endif; ?>
    <?php endforeach; ?>
        
    <?php echo submit_tag('', array('class' => 'save_and_cont')) ?>
</form>
<span><?php echo __('Note: You will be able to change this information later.') ?></span>