<?php use_helper('dtForm', 'Javascript', 'prProfilePhoto'); ?>

<?php echo form_remote_tag(array('url'    => 'content/flag', 
                                 'complete' => 'flag_request_complete(request)',
                            ), 
                           array('id' => 'flag',
                            )
        ); ?>
        

    <div class="photo">
        <?php echo profile_thumbnail_photo_tag($profile); ?><br />
                                                    
        <?php echo $profile->getUsername(); ?>
    </div>
    <div class="left">
        <fieldset>
            <?php echo button_to_function(__('Close window'), 'parent.Windows.close("flag_profile_window");', array('class' => 'button')); ?>
        </fieldset>
    </div>
    <br class="clear" />
</form>
