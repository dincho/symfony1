<?php use_helper('Object', 'dtForm', 'Javascript') ?>

<?php echo __("In order to match you with your Polish singles, we need to know WHO YOU'RE LOOKING FOR."); ?>
<?php echo form_tag('dashboard/searchCriteria', array('id' => 'self_desc_form', 'name' => 'self_desc_form')) ?>
    <?php $i=1; ?>
    <span class="title_first"><?php echo $i; ?>. <?php echo __('You\'re looking for someone aged:') ?></span>
    <?php echo input_tag('answers[ages][]', $search_criteria->getAgeValue(0), array('class' => 'age')) ?><?php echo __('&nbsp;to&nbsp;') ?>
    <?php echo input_tag('answers[ages][]', $search_criteria->getAgeValue(1), array('class' => 'age')) ?><br />
    <label for="answers_ages"><?php echo __('the "age factor" is: ') ?></label>
    <?php echo pr_select_match_weight('weights[ages]', false, array('class' => 'fieldweight')) ?>                        
    
    <?php foreach ($questions as $question): ?>
      
      <?php if( $question->getType() == 'radio' && isset($answers[$question->getId()]) ): ?>
      
        <?php $required_title = ($question->getIsRequired()) ? __('(select one or more, as needed)') : __('(optional, select one or more, as needed)'); ?>
        <?php $label_title =  ++$i .'. '. $question->getSearchTitle() . '<span> ' .$required_title. '</span>'; ?>
        <?php echo pr_label_for('answers[' . $question->getId() . ']', $label_title, array('class' => 'title')) ?>
        <?php foreach ($answers[$question->getId()] as $answer): ?>
          <?php echo checkbox_tag('answers['. $question->getid() .'][]', 
                                     $answer->getId(),
                                     ( isset($member_crit_desc[$question->getId()]) && $member_crit_desc[$question->getId()]->hasAnswer($answer->getId())) ? true : false, ($question->getSelectGreather()) ? array('onchange' => 'SC_select_greather(document.forms.self_desc_form.elements["answers[" + '. $question->getId().' +"][]"], this)') : array()) ?>
          <label><?php echo html_entity_decode($answer->getSearchTitle(), null, 'utf-8') ?></label><br />
        <?php endforeach; ?>
        <?php echo link_to_function(__('Select All'), 'SC_select_all(document.forms.self_desc_form.elements["answers[" + '. $question->getId().' +"][]"])'); ?> - any option is fine<br />
        <label for="weights_<?php echo $question->getId() ?>"><?php echo __($question->getFactorTitle()) ?></label>
        <?php echo pr_select_match_weight('weights[' . $question->getId() .']', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getMatchWeight() : 21, array('class' => 'fieldweight')) ?>
        
      <?php elseif( $question->getType() == 'select' && isset($answers[$question->getId()]) ): ?>
        
        <?php $required_title = ($question->getIsRequired()) ? __('(select one or more, as needed)') : __('(optional, select one or more, as needed)'); ?>
        <?php $label_title =  ++$i .'. '. $question->getSearchTitle() . '<span> ' .$required_title. '</span>'; ?>
        <?php echo pr_label_for('answers[' . $question->getId() . ']', $label_title, array('class' => 'title')) ?>
        <?php echo select_tag('answers['. $question->getid() .'][from]',
                              objects_for_select($answers[$question->getId()],
                              'getId', 
                              'getTitle',
                              ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getSelectValue(0) : null )) . __(' and ') ;?>
        <?php echo select_tag('answers['. $question->getid() .'][to]',
                              objects_for_select($answers[$question->getId()],
                              'getId', 
                              'getTitle',
                              ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getSelectValue(1) : null )) ?><br />
        <label for="weights_<?php echo $question->getId() ?>"><?php echo __($question->getFactorTitle()) ?></label>
        <?php echo pr_select_match_weight('weights[' . $question->getId() .']', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getMatchWeight() : 21, array('class' => 'fieldweight')) ?>
        
      <?php elseif( $question->getType() == 'native_lang' || $question->getType() == 'other_langs'): ?>
      
        <?php echo pr_label_for('answers[' . $question->getId() . ']', ++$i .'. '. $question->getSearchTitle(), array('class' => 'title')) ?>        
        <?php echo input_hidden_tag('answers['. $question->getid() .']', 1 ,array('class' => 'hidden')) ?><br />
        <label for="weights_<?php echo $question->getId() ?>"><?php echo __($question->getFactorTitle()) ?></label>
        <?php echo pr_select_match_weight('weights[' . $question->getId() .']', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getMatchWeight() : 21, array('class' => 'fieldweight')) ?>
        
      <?php endif; ?>
      
    <?php endforeach; ?>
    
    <br /><br />
    <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'save')) ?>
</form>