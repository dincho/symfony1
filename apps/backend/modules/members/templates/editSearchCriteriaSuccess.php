<?php use_helper('Object', 'dtForm', 'Javascript', 'fillIn') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail(), 'class=float-right') ?>
<br /><br />

<?php echo form_tag('members/editSearchCriteria', 'class=form id=self_description_form name=self_description_form') ?>
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  
  <div class="legend">Search Criteria</div>
  <fieldset class="form_fields">
    <?php $i=0; ?>
    <?php foreach ($questions as $question): ?>
      
      <?php if( $question->getType() == 'radio' && isset($answers[$question->getId()]) ): ?>
      
        <?php $required_title = ($question->getIsRequired()) ? '(select one or more, as needed)' : '(optional, select one or more, as needed)'; ?>
        <?php $label_title =  ++$i .'. '. $question->getSearchTitle() . '<span> ' .$required_title. '</span>'; ?>
        <?php echo pr_label_for('answers[' . $question->getId() . ']', $label_title, array('class' => 'full_row')) ?>
        <?php foreach ($answers[$question->getId()] as $answer): ?>
          <?php echo checkbox_tag('answers['. $question->getid() .'][]', 
                                     $answer->getId(),
                                     fillIn('answers['. $question->getId() .'][]', 'c', false, ( isset($member_crit_desc[$question->getId()]) && $member_crit_desc[$question->getId()]->hasAnswer($answer->getId()))),
                                     //( isset($member_crit_desc[$question->getId()]) && $member_crit_desc[$question->getId()]->hasAnswer($answer->getId())) ? true : false, 
                                     ($question->getSelectGreather()) ? array('onchange' => 'SC_select_greather(document.forms.self_desc_form.elements["answers[" + '. $question->getId().' +"][]"], this)') : array()) ?>
          <label><?php echo html_entity_decode($answer->getSearchTitle(), null, 'utf-8') ?></label><br />
        <?php endforeach; ?>
        <label><?php echo link_to_function('Select All', 'SC_select_all(document.forms.self_description_form.elements["answers[" + '. $question->getId().' +"][]"])'); ?> - any option is fine</label><br />
        <label for="weights_<?php echo $question->getId() ?>"><?php echo $question->getFactorTitle() ?></label>
        <?php echo pr_select_match_weight('weights[' . $question->getId() .']', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getMatchWeight() : 21, array('class' => 'fieldweight')) ?><br />
        
      <?php elseif( $question->getType() == 'select' && isset($answers[$question->getId()]) ): ?>
        
        <?php $required_title = ($question->getIsRequired()) ? '(select one or more, as needed)' : '(optional, select one or more, as needed)'; ?>
        <?php $label_title =  ++$i .'. '. $question->getSearchTitle() . '<span> ' .$required_title. '</span>'; ?>
        <?php echo pr_label_for('answers[' . $question->getId() . ']', $label_title, array('class' => 'full_row')) ?>
        <span class="float-left">
        <?php echo select_tag('answers['. $question->getid() .'][from]',
                              objects_for_select($answers[$question->getId()],
                              'getId', 
                              'getTitle',
                              ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getSelectValue(0) : null ), array('class' => 'double_select')) . ' and ' ;?>
        <?php echo select_tag('answers['. $question->getid() .'][to]',
                              objects_for_select($answers[$question->getId()],
                              'getId', 
                              'getTitle',
                              ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getSelectValue(1) : null ), array('class' => 'double_select')) ?>
        </span><br />
        <label for="weights_<?php echo $question->getId() ?>"><?php echo $question->getFactorTitle() ?></label>
        <?php echo pr_select_match_weight('weights[' . $question->getId() .']', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getMatchWeight() : 21, array('class' => 'fieldweight')) ?><br />
        
      <?php elseif( $question->getType() == 'native_lang' || $question->getType() == 'other_langs'): ?>
      
        <?php echo pr_label_for('answers[' . $question->getId() . ']', ++$i .'. '. $question->getSearchTitle(), array('class' => 'full_row')) ?>        
        <?php echo input_hidden_tag('answers['. $question->getid() .']', 1 ,array('class' => 'hidden')) ?><br />
        <label for="weights_<?php echo $question->getId() ?>"><?php echo $question->getFactorTitle() ?></label>
        <?php echo pr_select_match_weight('weights[' . $question->getId() .']', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getMatchWeight() : 21, array('class' => 'fieldweight')) ?><br />
      
      <?php elseif( $question->getType() == 'age'): ?>
        <?php $label_title =  ++$i .'. '. $question->getSearchTitle(); ?>
        <?php echo pr_label_for('answers[' . $question->getId() . ']', $label_title, array('class' => 'full_row')) ?>
        <span class="float-left">
        <?php echo input_tag('answers['. $question->getid() .'][]', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getAgeValue(0) : 18, array('class' => 'age')) ?><?php echo '&nbsp;to&nbsp;' ?>
        <?php echo input_tag('answers['. $question->getid() .'][]', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getAgeValue(1) : 100, array('class' => 'age')) ?>
        </span><br />
        <label for="answers_ages"><?php echo 'the "age factor" is: ' ?></label>
        <?php echo pr_select_match_weight('weights['. $question->getid() .']', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getMatchWeight() : 21, array('class' => 'fieldweight')) ?>    <br />    
      <?php endif; ?>
      
    <?php endforeach; ?>
    
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editSearchCriteria?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

<?php include_partial('members/bottomMenu', array('member_id' => $member->getId())); ?>