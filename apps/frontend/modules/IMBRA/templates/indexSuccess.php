<?php echo use_helper('dtForm', 'Object', 'fillIn') ?>

<?php echo form_tag('IMBRA/index', array('id' => 'imbra_2')) ?>
    <?php if( $imbra->getId() ): //old imbra ?>
        <?php echo __('Below are the answers you\'ve provided us for IMBRA. If any of them changed, you are required to update the application immediately.') ?><br />
        <?php echo __('If you are not US citizen, <a href="%CONFIRM_IMBRA_STATUS_URL%" class="sec_link">click here to leave this page</a>, otherwise please fill out this form.', array('%CONFIRM_IMBRA_STATUS_URL%' => url_for('IMBRA/confirmImbraStatus'))) ?><br />
        <span><?php echo __('Change the selection or answer and click Save on the bottom of the page.') ?></span><br /><br />
        <span class="public_reg_notice">
            <?php echo __('Due to the new legislation effective since March 6, 2006, the International Marriage Broker Act of 20005 (so called IMBRA), we must collect the following background information from each customer interested in using our services. We also have to make an electronic search on the National Sex Offender public registry and pertinent State Sex Offender public registry. This information will be translated to Polish and presented to any Polish women (or a men, if you\'re woman) who tries to contact you, or wants to reply to your message, or simply receives your message. In addition to your background check information, we will present a foreign person with the information in Polish, about legal rights and resources for immigrant victims of domestic violence. According to this law, we also have to inform you, whether it applies to you or not, that after filing a petition for a K nonimmigrant visa, you will be subject to a criminal background check.<br /><br />If you answer "YES" to any of the questions below, please provide a Detailed Statement of Explanation and Information, or alternatively any Necessary Optional Documentation. Additional documents may require a translation fee.') ?>
        </span>        
    <?php else: ?>
        <?php echo __('If you are US citizen living in US or US citizen not living in US but planning to live in US with your future foreign spouse, US law requires you to fill out this form. This is not our idea. It\'s your government.') ?><br />
        <span class="public_reg_notice"><?php echo __('(Estimated time 120 seconds)') ?></span><br /><br />
        <?php echo __('If you are not US citizen, <a href="%CONFIRM_IMBRA_STATUS_URL%" class="sec_link">click here to leave this page</a>, otherwise please fill out this form.', array('%CONFIRM_IMBRA_STATUS_URL%' => url_for('IMBRA/confirmImbraStatus'))) ?><br /><br />
        <span class="public_reg_notice">
            <strong><?php echo __('Required by United States\' International Marriage Broker Regulation Act of 2005 ') ?></strong><br />
            <?php echo __('Due to the new legislation effective since March 6, 2006, the International Marriage Broker Act of 20005 (so called IMBRA), we must collect the following background information from each customer interested in using our services. We also have to make an electronic search on the National Sex Offender public registry and pertinent State Sex Offender public registry. This information will be translated to Polish and presented to any Polish women (or a men, if you\'re woman) who tries to contact you, or wants to reply to your message, or simply receives your message. In addition to your background check information, we will present a foreign person with the information in Polish, about legal rights and resources for immigrant victims of domestic violence. According to this law, we also have to inform you, whether it applies to you or not, that after filing a petition for a K nonimmigrant visa, you will be subject to a criminal background check.<br /><br />If you answer "YES" to any of the questions below, please provide a Detailed Statement of Explanation and Information, or alternatively any Necessary Optional Documentation. Additional documents may require a translation fee.') ?>
        </span>        
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
    
    <span class="public_reg_notice"><?php echo __('I certify and attest, under penalty of perjury and false swearing, that I am 19 years of age or older, of sound mind, and that my above BACKGROUND INFORMATION as well as all accompanying documents I have provided, if any, is true, correct and complete, and that should any such information change at any time, I will provide such changes or updates to PolishRomance.com. FURTHERMORE, I authorize PolishRomance.com to release and provide this information and any accompanying documentation along with any subsequent changes or updates, in any format, to all foreign ladies (or gentlemen, if you\'re a woman), interested in contacting me or replying to my message or receiving my message. I hereby waive any privacy rights from release of this information and I release and hold harmless, and forever discharge, PolishRomance.com, its officers, directors, shareholders, employees and agents, from any and all liabilities arising from the release of this information, the accompanying documents, and any changes or updates, and any use thereof.<br /><br />Electronic Signature (Type here your full name, this will be considered as your signature in this document): ') ?></span><br />
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
    <span><?php echo __('The application will not be "signed" in the sense of a traditional paper document. To verify the contents of the application, the signatory must enter any alpha/numeric character(s) or combination thereof of his or her choosing, preceded and followed by the forward slash (/) symbol. The PolishRomance does not determine or pre-approve what the entry should be, but simply presumes that this specific entry has been adopted to serve the function of the signature. Most signatories simply enter their names between the two forward slashes, although acceptable "signatures" could include /john doe/; /jd/; or /123-4567/. The application may still be validated to check for missing information or errors even if the signature and date signed fields are left blank.') ?></span><br /><br /><br />
    
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