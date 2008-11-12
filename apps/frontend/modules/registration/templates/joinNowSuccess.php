<?php use_helper('dtForm', 'Javascript'); ?>

<?php echo __('Please register. Reminder: If you\'re not 19 or older, you are not allowed to be here - you must %link_to_leave_now%', array('%link_to_leave_now%' => link_to(__('leave now!'), 'http://google.com/'))) ?><br />
<span><?php echo __('Note: You will be able to update this information later.') ?></span>
<?php echo form_tag('registration/joinNow', array('id' => 'registration_box_complete_page')) ?>
    <fieldset>
        <!-- 
        <label for="another_language"></label>
        <input type="text" name="another_language" id="another_language" /> <span class="another_language_span">(Please specify)</span><br />
         -->
         
        <?php echo pr_label_for('email', 'Your email') ?>
        <?php echo input_tag('email') ?><br />
        
        <?php echo pr_label_for('password', 'Create Password') ?>
        <?php echo input_password_tag('password') ?><br />
        
        <?php echo pr_label_for('repeat_password', 'Repeat Password') ?>
        <?php echo input_password_tag('repeat_password') ?><br />
        
        <?php echo pr_label_for('looking_for', 'You are') ?>
        <?php echo select_tag('looking_for', looking_for_options()) ?><br />

        <?php echo pr_label_for('username'); ?>
        <?php echo input_tag('username') ?>
        <span class="check_available">
        <?php echo link_to_remote(image_tag('input/butt_availability.gif'), array(
            'update' => 'ajax_response',
            'url'    => 'ajax/usernameExists',
            'with'     => "'username=' + $('username').value",
        )) ?>        
        </span><br />
        <div id="ajax_response"></div>
                
        <?php $tos_text = __('I am 18 or older and I agree to the %link_to_user_agreement% and %link_to_privacy_policy%.', 
                            array('%link_to_user_agreement%' => link_to(__('Terms of Use'), '@page?slug=user_agreement'),
                                  '%link_to_privacy_policy%' => link_to(__('Privacy Policy'), '@page?slug=privacy_policy'))) ?>
        <?php echo pr_label_for('tos', $tos_text, array('class' => 'tos'), false) ?>
        <?php echo checkbox_tag('tos', 1, false, array('class' => 'tos_input')) ?>
        <?php echo submit_tag('', array('class' => 'submit_join')) ?>
    </fieldset>
</form>