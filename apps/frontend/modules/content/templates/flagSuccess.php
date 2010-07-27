<?php use_helper('dtForm', 'Javascript', 'prProfilePhoto'); ?>

<?php echo form_remote_tag(array('url'    => 'content/flag', 
                                 'complete' => 'flag_request_complete(request)',
                            ), 
                           array('id' => 'flag',
                            )
        ); ?>
        
    <?php echo input_hidden_tag('username', $profile->getUsername(), array('class' => 'hidden')) ?>
    <?php echo input_hidden_tag('layout', $sf_params->get('layout'), array('class' => 'hidden')) ?>

    <div class="photo">
        <?php echo profile_thumbnail_photo_tag($profile); ?><br />
                                                    
        <?php echo $profile->getUsername(); ?>
    </div>
    <div class="left">
        <?php echo pr_label_for('flag_category', __('Please tell us why you are flagging this member.')) ?>
        <fieldset>
            <?php foreach($flag_categories as $flag_cat): ?>
                <?php echo radiobutton_tag('flag_category', $flag_cat->getId(), false) ?>
                <?php echo pr_label_for('flag_category_' . $flag_cat->getId(), __($flag_cat->getTitle())) ?><br />
            <?php endforeach; ?><br />
            
            <?php if( sfConfig::get('app_settings_flags_comment_field') ): ?>
                <span><?php echo __('(type an optional comment below)') ?></span><br />
                <?php echo textarea_tag('comment', null, array('rows' => 4, 'cols' => '65', 'class' => 'text_area')) ?>
                <br /><br /><br />
            <?php endif; ?>
            
            
            
            <?php echo submit_tag(__('Submit'), array('class' => 'button' )); ?>
            <?php echo button_to_function(__('Cancel'), 'parent.Windows.close("flag_profile_window");', array('class' => 'button')); ?>
        </fieldset>
    </div>
    <br class="clear" />
</form>
