<?php use_helper('dtForm') ?>
<?php slot('header_title') ?>
    <?php echo __('Photos headline') ?>
<?php end_slot(); ?>

<?php echo __('Photos instructions') ?>
<?php echo __('Photos note') ?>

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
                  <span <?php if($sf_request->getParameter('confirm_delete') == $photo->getId()) echo 'class=delete'; ?>>
                    <?php echo image_tag( $photo->getImageUrlPath('file', '100x100') ) ?>
                  </span>
                  <?php echo button_to(__('Delete'), 'registration/photos?confirm_delete=' . $photo->getId(), array('class' => 'button_mini')) ?>
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
    <?php echo input_file_tag('new_photo', array('class' => 'file_input')) ?>
    <?php echo submit_tag(__('Upload'), array('id' => 'upload', 'class' => 'button')) ?>
    <hr /><br />
        
    <?php echo __("YouTube URL ") ?><span><?php echo __('(enter the URL of a YouTube video - optional)') ?></span><br />
    <?php echo input_tag('youtube_url', $member->getYoutubeVidUrl(), array('class' => 'input_text_width', 'size' => 60)) ?><br /><br />
    
    <?php echo submit_tag(__('Save and Continue'), array('class' => 'button', 'name' => 'save')) ?><br /><br />
    <?php echo __('Photos note') ?>
</form>