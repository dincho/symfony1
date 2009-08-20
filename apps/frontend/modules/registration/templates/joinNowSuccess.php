<?php use_helper('dtForm', 'Javascript'); ?>

<?php echo __('JoinNow instructions') ?>
<?php echo form_tag('registration/joinNow', array('id' => 'registration_box_complete_page', 'autocomplete' => 'off')) ?>
    <fieldset>
        <!-- 
        <label for="another_language"></label>
        <input type="text" name="another_language" id="another_language" /> <span class="another_language_span">(Please specify)</span><br />
         -->
         
        <?php echo pr_label_for('email', __('Your email') . '<span style="color:red;">*</span>') ?>
        <?php echo input_tag('email') ?><br />
        
        <?php echo pr_label_for('password', __('Create Password') . '<span style="color:red;">*</span>') ?>
        <?php echo input_password_tag('password') ?><br />
        
        <?php echo pr_label_for('repeat_password', __('Repeat Password') . '<span style="color:red;">*</span>') ?>
        <?php echo input_password_tag('repeat_password') ?><br />
        
        <?php echo pr_label_for('looking_for', __('You are') . '<span style="color:red;">*</span>') ?>
        <?php echo select_tag('looking_for', looking_for_options()) ?><br />

        <?php echo pr_label_for('username', __('Username') . '<span style="color:red;">*</span>'); ?>
        <?php echo input_tag('username') ?>
        <span class="check_available">
        <?php echo button_to_remote(__('Check Availability'), array(
            'update' => 'ajax_response',
            'url'    => 'ajax/usernameExists',
            'with'     => "'username=' + $('username').value",
            'script'    => true
        ), array('class' => 'button_mini butt_availability')) ?>        
        </span><br class="clear" />
        </fieldset>
        <div id="ajax_response"></div>
                
        <?php $tos_text = __('I am 18 or older and I agree to the <a href="%URL_FOR_TERMS%" class="sec_link">Terms of Use</a> and <a href="%URL_FOR_PRIVACY_POLICY%" class="sec_link">Privacy Policy</a>.') ?>
        <?php echo pr_label_for('tos', $tos_text, array('class' => 'tos'), false) ?>
        <?php echo checkbox_tag('tos', 1, false, array('class' => 'tos_input', 'style' => 'float: left; margin-left: 333px;')) ?>
        
        <?php echo submit_tag(__('Save and Continue'), array('class' => 'button_save_and_cont')) ?>
<!--    </fieldset>-->
</form>

<?php slot('change_language') ?>
    <?php include_partial('content/lang'); ?>
<?php end_slot(); ?>