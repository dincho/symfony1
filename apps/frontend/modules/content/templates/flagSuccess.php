<?php use_helper('dtForm', 'Javascript', 'prProfilePhoto'); ?>

<?php echo form_remote_tag(array('url'    => 'content/flag',
                                 'complete' => 'flag_request_complete(request)'),
                           array('id' => 'flag')); ?>

    <?php echo input_hidden_tag('username', $profile->getUsername(), array('class' => 'hidden')) ?>
    <?php echo input_hidden_tag('layout', $sf_params->get('layout'), array('class' => 'hidden')) ?>

    <div>
        <?php echo pr_label_for('comment', __('Please tell us why you are flagging this member.')) ?>
        <fieldset>
            <?php echo textarea_tag('comment', null, array('rows' => '4', 'cols' => '65', 'maxlength'=>'255', 'class' => 'text_area')) ?>
            <br />
            <?php echo submit_tag(__('Submit'), array('class' => 'button' )); ?>
            <?php echo button_to_function(__('Cancel'), 'parent.Windows.close("flag_profile_window");', array('class' => 'button cancel')); ?>
        </fieldset>
    </div>
    <br class="clear" />
</form>
