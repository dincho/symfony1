<?php echo __('You may change your photos here') ?><br />
<span><?php echo __('Make changes and click Save on the bottom of the page.') ?></span><br /><br />
<?php echo __('You may upload any size of photo - we will shrink it to 700x700 pixels maximum; your high quality will be preserved.') ?><br />
<?php echo __('Use these formats only: jpg, png and gif.') ?><br /><br />
                
<?php echo form_tag('editProfile/photos', 
                  array('id' => 'edit_photos',
                        'multipart' => true, 
                        'onsubmit' => 'return check_upload_field(\''. __('You have not uploaded the file you have selected! Do you want to continue?') .'\');'
                        )) ?>
    <?php $cnt_photos = count($photos); ?>
    <?php if($cnt_photos > 0): ?>
        <div class="photos">
            <?php $i=1;foreach ($photos as $photo): ?>
              <div class="photo">
                <?php echo radiobutton_tag('main_photo', $photo->getId(), $photo->isMain(), array('id' => 'main_photo')) ?>
                <?php if( $photo->isMain()): ?>
                    <label for="main_photo"><?php echo __('Main Photo') ?></label>
                <?php endif; ?><br />
                  <span <?php if($sf_request->getParameter('confirm_delete') == $photo->getId()) echo 'class="delete"'; ?>>
                    <?php echo image_tag( $photo->getImageUrlPath('file', '100x100') ) ?>
                  </span>
                  <?php echo button_to(__('Delete'), 'editProfile/photos?confirm_delete=' . $photo->getId(), array('class' => 'button_mini')) ?>
              </div>
        <?php if( $i++ % 5 == 0 && $i <= $cnt_photos): ?>
        </div>
        <div class="photos">
        <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <p class="photo_authenticity float-right">
        <?php echo link_to(($member->hasAuthPhoto()) ? __('Update Your Verification Photo') : __('Verify authenticity'), 'editProfile/photoAuthenticity', array('class' => 'sec_link')); ?>
    </p>
    <br class="clear" />
    <hr />
    
    <p class="note"><?php echo __('Note: You can upload up to %MAX_PHOTOS% photos', array('%MAX_PHOTOS%' => $member->getSubscription()->getPostPhotos())) ?></p>
    <?php echo input_file_tag('new_photo', array('class' => '')) ?>
    <?php echo submit_tag(__('Upload'), array('id' => 'upload', 'class' => 'button', 'onclick' => 'save_button = false')) ?>
    <hr /><br />
        
    <fieldset>
    <?php if(!$sf_request->getParameter('confirm_delete')):  ?>
        <br /><br /><?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
        <?php echo submit_tag(__('Save'), array('class' => 'button', 'name' => 'save', 'onclick' => 'save_button = true')) ?>
    <?php else: ?>
        <br /><br /><span><?php echo __('Please select Yes or No at the top of the page') ?></span><br />
        <?php echo submit_tag(__('Save'), array('class' => 'button_disabled', 'name' => 'save', 'disabled' => 'disabled')) ?>
    <?php endif; ?>
    </fieldset>
</form>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
