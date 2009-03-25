<?php use_helper('Object', 'dtForm', 'fillIn') ?>

<?php echo __('Here you may change your self-description.') ?><br />
<span><?php echo __('Make changes and click Save at the bottom of the page.') ?></span><br />

<?php echo form_tag('editProfile/selfDescription', array('id' => 'self_desc_form')) ?>
    <?php $i=0; ?>
    <?php foreach ($questions as $question): ?>
      <?php include_partial('editProfile/question_title', array('question' => $question, 'i' => $i++)); ?>
      <?php if( $question->getType() == 'radio' && isset($answers[$question->getId()]) ): ?>
        <?php include_partial('editProfile/question_type_radio', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
        <?php include_partial('question_other', array('question' => $question, 'member_answers' => $member_answers) ); ?>
      <?php elseif( $question->getType() == 'select' && isset($answers[$question->getId()]) ): ?>
        <?php include_partial('editProfile/question_type_select', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
        <?php include_partial('question_other', array('question' => $question, 'member_answers' => $member_answers) ); ?>
      <?php elseif( $question->getType() == 'native_lang' ): ?>
        <?php echo pr_select_language_tag('answers['. $question->getid() .']', ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getCustom() : null) ?><br />
        <?php include_partial('question_other_checkbox', array('question' => $question, 'member_answers' => $member_answers) ); ?>
      <?php elseif( $question->getType() == 'age' ): ?>
        <?php include_partial('editProfile/question_type_age', array('member' => $member, 'question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
        <?php include_partial('question_other', array('question' => $question, 'member_answers' => $member_answers) ); ?>
      <?php elseif( $question->getType() == 'other_langs' ): ?>
        <?php include_partial('editProfile/question_type_other_langs', array('question' => $question, 'member_answers' => $member_answers, 'answers' => $answers)); ?>
        <?php include_partial('question_other_checkbox', array('question' => $question, 'member_answers' => $member_answers) ); ?>
      <?php endif; ?>
    <?php endforeach; ?>
        
    <br /><br /><?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?>
</form>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>