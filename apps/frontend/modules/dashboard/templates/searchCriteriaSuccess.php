<?php use_helper('Object', 'dtForm', 'Javascript', 'fillIn') ?>
<?php slot('header_title') ?>
    <?php echo __('Search criteria headline') ?>
<?php end_slot(); ?>

<?php echo __("Search criteria instructions"); ?>
<?php echo form_tag('dashboard/searchCriteria', array('id' => 'self_desc_form', 'name' => 'self_desc_form')) ?>
    <?php $i=0; ?>
    <?php foreach ($questions as $question): ?>
      
      <?php if( $question->getType() == 'radio' && isset($answers[$question->getId()]) ): ?>
      
        <?php $required_title = ($question->getIsRequired()) ? __('(select one or more, as needed)') : __('(optional, select one or more, as needed)'); ?>
        <?php $label_title =  ++$i .'. '. $question->getSearchTitle() . '<span> ' .$required_title. '</span>'; ?>
        <?php echo content_tag('div', $label_title, array('class' => 'title')) ?>
        <?php foreach ($answers[$question->getId()] as $answer): ?>
          <?php echo checkbox_tag('answers['. $question->getid() .'][]', 
                                     $answer->getId(), fillIn('answers['. $question->getid() .'][]', 'c', false, ( isset($member_crit_desc[$question->getId()]) && $member_crit_desc[$question->getId()]->hasAnswer($answer->getId()))),
                                     ($question->getSelectGreather()) ? array('onchange' => 'SC_select_greather(document.forms.self_desc_form.elements["answers[" + '. $question->getId().' +"][]"], this)') : array()) ?>
          <label><?php echo $answer->getSearchTitle(ESC_RAW) ?></label><br />
        <?php endforeach; ?>
        <?php echo link_to_function(__('Select All'), 'SC_select_all(document.forms.self_desc_form.elements["answers[" + '. $question->getId().' +"][]"])'); ?> - any option is fine<br />
        <label for="weights_<?php echo $question->getId() ?>"><?php echo __($question->getFactorTitle()) ?></label>
        <?php echo pr_select_match_weight('weights[' . $question->getId() .']', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getMatchWeight() : 21, array('class' => 'fieldweight')) ?>
        
      <?php elseif( $question->getType() == 'select' && isset($answers[$question->getId()]) ): ?>
        
        <?php $required_title = ($question->getIsRequired()) ? __('(select one or more, as needed)') : __('(optional, select one or more, as needed)'); ?>
        <?php $label_title =  ++$i .'. '. $question->getSearchTitle() . '<span> ' .$required_title. '</span>'; ?>
        <?php echo content_tag('div', $label_title, array('class' => 'title')) ?>
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
      
      <?php elseif( $question->getType() == 'age'): ?>
        <?php $label_title =  ++$i .'. '. $question->getSearchTitle(); ?>
        <?php $label_class = ($i == 1) ? 'title_first'  : 'title'; ?>
        <?php echo content_tag('div', $label_title, array('class' => $label_class)) ?>
        <?php echo input_tag('answers['. $question->getid() .'][]', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getAgeValue(0) : 18, array('class' => 'age')) ?><?php echo __('&nbsp;to&nbsp;') ?>
        <?php echo input_tag('answers['. $question->getid() .'][]', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getAgeValue(1) : 100, array('class' => 'age')) ?><br />
        <label><?php echo __('the "age factor" is: ') ?></label>
        <?php echo pr_select_match_weight('weights['. $question->getid() .']', ( isset($member_crit_desc[$question->getId()]) ) ? $member_crit_desc[$question->getId()]->getMatchWeight() : 21, array('class' => 'fieldweight')) ?>        
      <?php endif; ?>
      
    <?php endforeach; ?>
    
    <br /><br />
    <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?>
</form>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>