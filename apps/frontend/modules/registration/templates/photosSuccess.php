<?php use_helper('dtForm') ?>
Gee, we almost forgot! Photos. Your Future love wants to see you!<br />
You may upload any size of photo - we will shrink it to 700x700 pixels maximum; your high quality will be preserved.<br />
Use these formats only: jpg, png and gif.<br />
<span>Note: You will be able to change photos after you finish the registration</span><br /><br />

<?php echo form_tag('registration/photos', array('multipart' => true)) ?>
    <?php $cnt_photos = count($photos); ?>
    <?php if($cnt_photos > 0): ?>
        <div class="photos">
            <?php $i=1;foreach ($photos as $photo): ?>
              <div class="photo">
                <?php echo radiobutton_tag('main_photo', $photo->getId(), $photo->isMain()) ?>
                <?php if( $photo->isMain()): ?>
                    <label for="main_photo"><?php echo __('Main Photo') ?></label>
                <?php endif; ?><br />
                  <span>
                    <?php echo image_tag( $photo->getImageUrlPath('file', '100x100') ) ?>
                  </span>
                  <?php echo button_to(__('Delete'), 'editProfile/deletePhoto?id=' . $photo->getId(), array('class' => 'button_mini', 'confirm' => __('Are you sure you want to delete this photo?'))) ?>
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
    <?php echo input_file_tag('new_photo', array('class' => 'file_input')) ?><br />
    <?php echo submit_tag('Upload', array('id' => 'upload', 'class' => 'button')) ?>
    <hr /><br />
        
    <?php echo __("YouTube URL ") ?><span><?php echo __('(enter the URL of a YouTube video - optional)') ?></span><br />
    <?php echo input_tag('youtube_url', $member->getYoutubeVidUrl(), array('class' => 'input_text_width', 'size' => 60)) ?><br /><br />
    
    <?php echo submit_tag(__('Save and Continue'), array('class' => 'button', 'name' => 'save')) ?><br /><br />
    <span><?php echo __('Note: You can change your photos later.') ?></span>
</form>