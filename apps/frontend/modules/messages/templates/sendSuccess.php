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
    
    <fieldset class="template">
        <?php include_component('messages', 'selectPredefinedMessage', array('subject_field_id' => 'title', 'body_field_id' => 'your_story', )); ?>
    </fieldset>

    <fieldset class="background_f4">
        <div id="send_text" class="new_message_notice"><span><?php echo __('Never include your last name, e-mail address, home address, phone number, place of work and any other identifying information in initial messages with other members'); ?></span>
        </div>
        <?php echo textarea_tag('content',  $draft->getBody(), array('id' => 'your_story', 
                                                                        'rows' => 10, 'cols' => 30)) ?>
        <br />
    </fieldset>

    <fieldset class="actions">
        <?php echo submit_tag(__('Send'), array('class' => 'button')) ?>
        <?php echo button_to_function(__('Save Now'), 'save_draft();', array('class' => 'button', 'id' => 'save_to_draft_btn')) ?>
        <?php echo button_to_remote(__('Discard'), array('url'      => 'messages/discard?draft_id=' . $draft->getId(),
                                                         'complete' => 'draft_complete(request)',
                                                         'with'     => "'layout=' + $('layout').value",
                                                         'script'   => 'true', 
                                                    ), 
                                                   array('class' => 'button cancel', )) ?>
        <br />
    </fieldset>
    <br />
  
</form>

<?php include_partial('draft_save', array('draft' => $draft)); ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>


