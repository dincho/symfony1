<?php use_helper('Javascript', 'dtForm', 'prProfilePhoto') ?>



<?php if( $sf_request->getParameter('cancel_url') ): ?>
    <div class="thread_actions">
        <?php echo button_to(__('back to previous page'), base64_decode(strtr($sf_request->getParameter('cancel_url'), '-_,', '+/=')), array('class' => 'button')); ?> 
    </div>
<?php endif; ?>

<?php echo form_remote_tag(array('url'      => 'messages/send', 
                                 'complete' => 'send_message_complete(request)',
                            ), 
                           array('class'  => 'msg_form', 
                                 'id' => 'send_message_form',
                            )
        ); ?>
    <?php echo input_hidden_tag('recipient_id', $recipient->getId(), 'class=hidden') ?>
    <?php echo input_hidden_tag('draft_id', $draft->getId(), 'class=hidden') ?>
    <?php echo input_hidden_tag('layout', $sf_params->get('layout'), array('class' => 'hidden')); ?>
    
    <div id="feedback">&nbsp;</div>
    
    <fieldset class="actions">
        
        <div class="new_message_profile_photo" >
            <?php if( $recipient ): ?>
                <?php echo link_to_unless((!$recipient->isActive() || $sf_params->get('layout') == 'window'), 
                                            profile_thumbnail_photo_tag($recipient), '@profile?username=' . $recipient->getUsername()); ?>
            <?php endif; ?>
        </div>

        <?php echo pr_label_for('to', __('To:')) ?>
        <span class="msg_to"><?php echo $recipient->getUsername() ?></span><br />
        
        <?php echo pr_label_for('predefined_message', __('Template:')); ?>
        <?php include_component('messages', 'selectPredefinedMessage', array('subject_field_id' => 'title', 'body_field_id' => 'your_story', )); ?><br />
            
            
        <?php echo pr_label_for('subject', __('Subject:')) ?>
        <?php echo input_tag('subject', $draft->getSubject(), array('id' => 'title')) ?><br />
    </fieldset>

    <fieldset class="background_f4">
        <?php echo pr_label_for('content', __('Message:')) ?>
        <?php echo textarea_tag('content',  $draft->getBody(), array('id' => 'your_story', 
                                                                        'rows' => 10, 'cols' => 30)) ?>
        <br />
        <?php if( !sfConfig::get('app_settings_imbra_disable') && !$sender->getLastImbra(true) && $recipient->getLastImbra(true) ): ?>
            <label><?php echo checkbox_tag('tos', 1, false, array('id' => 'tos', 'class' => 'tos')) ?></label>
            <label class="imbra_tos">
                <?php echo __('I am familiar with this member IMBRA and I accept the TOS', 
                            array('%URL_FOR_PROFILE_IMBRA%' => url_for('@profile?username=' . $recipient->getUsername() . '#profile_imbra_info'), '%URL_FOR_IMMIGRANT_RIGHTS%' => url_for('@page?slug=immigrant_rights'))) ?>
          </label>
        <?php endif; ?>
    
    </fieldset>

    <fieldset class="actions">
        <label></label>
        <?php echo submit_tag(__('Send'), array('class' => 'button')) ?>
        <?php echo button_to_function(__('Save Now'), 'save_draft();', array('class' => 'button', 'id' => 'save_to_draft_btn', 'disabled' => 'disabled')) ?>
        <?php echo button_to_remote(__('Discard'), array('url'      => 'messages/discard?draft_id=' . $draft->getId(),
                                                         'complete' => 'draft_complete(request)',
                                                         'with'     => "'layout=' + $('layout').value",
                                                         'script'   => 'true', 
                                                    ), 
                                                   array('class' => 'button', )) ?>
        <br />
    </fieldset>
  
</form>

<?php include_partial('draft_save', array('draft' => $draft)); ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>


