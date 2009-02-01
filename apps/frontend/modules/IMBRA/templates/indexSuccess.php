<?php echo use_helper('dtForm', 'Object', 'fillIn') ?>

<?php slot('header_title') ?>
    <?php echo __('IMBRA headline') ?>
<?php end_slot(); ?>

<?php echo form_tag('IMBRA/index', array('id' => 'imbra_2')) ?>
    <?php if( $imbra->getId() ): //old imbra ?>
        <?php echo __('IMBRA instructions (edit)', array('%URL_FOR_CONFIRM_IMBRA_STATUS%' => url_for('IMBRA/confirmImbraStatus'))) ?>
    <?php else: ?>
        <?php echo __('IMBRA instructions', array('%URL_FOR_CONFIRM_IMBRA_STATUS%' => url_for('IMBRA/confirmImbraStatus'))) ?>
    <?php endif; ?>
    <hr />
    <?php $request_answers = $sf_request->getParameter('answers') ?>
    <?php foreach ($sf_data->getRaw('imbra_questions') as $question): ?>
        <?php echo pr_label_for('answers[' . $question->getId() . ']', $question->getTitle()); ?><br />
        <?php if( !$question->getOnlyExplain() ): ?>
            <?php echo label_for('answers[' . $question->getId() . ']', 'No') ?>
            <?php echo radiobutton_tag('answers[' . $question->getId() . ']', 0, fillIn('answers[' . $question->getId() . ']', 'r', false, (isset($imbra_answers[$question->getId()]) && $imbra_answers[$question->getId()]->getAnswer() == 0)), array('onchange' => 'imbra_explain('. $question->getId().', this.value)') ) ?>
                    
            <?php echo label_for('answers[' . $question->getId() . ']', 'Yes') ?>
            <?php echo radiobutton_tag('answers[' . $question->getId() . ']', 1,  fillIn('answers[' . $question->getId() . ']', 'r', false, (isset($imbra_answers[$question->getId()]) && $imbra_answers[$question->getId()]->getAnswer() == 1)), array('onchange' => 'imbra_explain('. $question->getId().', this.value)')) ?><br />
            <?php echo pr_label_for('explains[' . $question->getId() . ']', $question->getExplainTitle(), array('style' => (!$question->getOnlyExplain() && (!isset($imbra_answers[$question->getId()]) || $imbra_answers[$question->getId()]->getAnswer() == 0) && (!isset($request_answers[$question->getId()]) || $request_answers[$question->getId()] == 0) ) ? 'display: none;' : '' )) ?><br />
        <?php endif; ?>
        
        <?php echo textarea_tag('explains[' . $question->getId() . ']', 
                   (isset($imbra_answers[$question->getId()])) ? $imbra_answers[$question->getId()]->getExplanation() : null, 
                   array('style' => (!$question->getOnlyExplain() && (!isset($imbra_answers[$question->getId()]) || $imbra_answers[$question->getId()]->getAnswer() == 0) && (!isset($request_answers[$question->getId()]) || $request_answers[$question->getId()] == 0) ) ? 'display: none;' : '' )) ?>
        <hr />
    <?php endforeach; ?>
    
    <?php echo __('IMBRA notice') ?>
    <?php echo pr_label_for('date', 'Date', array('class' => 'form_1')) ?>
    <?php echo ($imbra->getCreatedAt()) ? $imbra->getCreatedAt('M d, Y') : date('M d, Y') ?>
    <br />
    
    <?php echo pr_label_for('name', 'Name', array('class' => 'form_1')) ?>
    <?php echo object_input_tag($imbra, 'getName', array('class' => 'input_text_width', 'size' => 26)) ?><br />
    
    <?php echo pr_label_for('dob', 'Date of Birth', array('class' => 'form_1')) ?>
    <?php echo object_input_tag($imbra, 'getDob',  array('class' => 'input_text_width', 'size' => 26)) ?><br />
    
    <?php echo pr_label_for('address', 'Address', array('class' => 'form_1')) ?>
    <?php echo object_input_tag($imbra, 'getAddress', array('class' => 'input_text_width', 'size' => 26)) ?><br />
    
    <?php echo pr_label_for('city', 'City', array('class' => 'form_1')) ?>
    <?php echo object_input_tag($imbra, 'getCity', array('class' => 'input_text_width', 'size' => 26)) ?><br />
    
    <?php echo pr_label_for('state_id', 'State', array('class' => 'form_1')) ?>
    <?php echo pr_select_state_tag('US', 'state_id', $imbra->getStateId(), array('include_custom' => '- Select -', 'class' => 'input_text_width')) ?><br />
    
    
    <?php echo pr_label_for('zip', 'Zip Code', array('class' => 'form_1')) ?>
    <?php echo object_input_tag($imbra, 'getZip', array('class' => 'input_text_width', 'size' => 26)) ?><br />
    
    <?php echo pr_label_for('phone', 'Telephone', array('class' => 'form_1')) ?>
    <?php echo object_input_tag($imbra, 'getPhone', array('class' => 'input_text_width', 'size' => 26)) ?><br />
        
    <hr />
    <?php echo __('IMBRA note') ?>
    
    <?php if( $imbra->getId() ): ?>
        <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link')) ?><br />
        <?php echo submit_tag(__('Resubmit'), array('class' => 'button')) ?><br /><br /><br /><br />
        <?php slot('footer_menu') ?>
            <?php include_partial('content/footer_menu') ?>
        <?php end_slot(); ?>        
    <?php else: ?>
        <?php echo submit_tag(__('Save and Continue'), array('class' => 'button')) ?>
    <?php endif; ?>
</form>