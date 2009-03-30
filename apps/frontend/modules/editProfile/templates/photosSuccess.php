<?php echo __('You may change your photos here') ?><br />
<span><?php echo __('Make changes and click Save on the bottom of the page.') ?></span><br /><br />
<?php echo __('You may upload any size of photo - we will shrink it to 700x700 pixels maximum; your high quality will be preserved.') ?><br />
<?php echo __('Use these formats only: jpg, png and gif.') ?><br /><br />
                
<?php echo form_tag('editProfile/photos', array('multipart' => true)) ?>
    <?php $cnt_photos = count($photos); ?>
    <?php if($cnt_photos > 0): ?>
        <div class="photos">
            <?php $i=1;foreach ($photos as $photo): ?>
              <div class="photo">
                <?php echo radiobutton_tag('main_photo', $photo->getId(), $photo->isMain()) ?>
                <?php if( $photo->isMain()): ?>
                    <label for="main_photo"><?php echo __('Main Photo') ?></label>
                <?php endif; ?><br />
                  <span <?php if($sf_request->getParameter('confirm_delete') == $photo->getId()) echo 'class=delete'; ?>>
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
    <br class="clear" /><hr />
    
    <p class="note"><?php echo __('Note: You can upload up to %MAX_PHOTOS% photos', array('%MAX_PHOTOS%' => $member->getSubscription()->getPostPhotos())) ?></p>
    <?php echo input_file_tag('new_photo', array('class' => '')) ?>
    <?php echo submit_tag(__('Upload'), array('id' => 'upload', 'class' => 'button')) ?>
    <hr /><br />
        
    <?php echo __('YouTube URL ') ?><span><?php echo __('(enter the URL of a YouTube video - optional)') ?></span><br />
    <?php echo input_tag('youtube_url', $member->getYoutubeVidUrl(), array('class' => 'input_text_width', 'size' => 60)) ?><br />
    <?php if(!$sf_request->getParameter('confirm_delete')):  ?>
        <br /><br /><?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
        <?php echo submit_tag(__('Save'), array('class' => 'button', 'name' => 'save')) ?>
    <?php else: ?>
        <br /><br /><span><?php echo __('Please select Yes or No at the top of the page') ?></span><br />
        <?php echo submit_tag(__('Save'), array('class' => 'button_disabled', 'name' => 'save', 'disabled' => 'disabled')) ?>
    <?php endif; ?>
</form>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>