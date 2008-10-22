<?php use_helper('dtForm') ?>
Gee, we almost forgot! Photos. Your Future love wants to see you!<br />
You may upload any size of photo - we will shrink it to 700x700 pixels maximum; your high quality will be preserved.<br />
Use these formats only: jpg, png and gif.<br />
<span>Note: You will be able to change photos after you finish the registration</span><br /><br />
At least 1 photograph is required in order to continue.<br />
<?php echo form_tag('registration/photos', array('multipart' => true)) ?>
    <?php if(count($photos) > 0): ?>
        <div id="photos">
            <?php foreach ($photos as $photo): ?>
              <div class="photo">
                <?php echo radiobutton_tag('main_photo', $photo->getId(), $photo->getIsMain()) ?>
                <?php if( $photo->getIsMain()): ?>
                    <label for="main_photo">Main Photo</label>
                <?php endif; ?><br />
                  <span>
                    <?php echo image_tag( $photo->getImageUrlPath('file', '100x100') ) ?>
                  </span>
                <?php echo button_to('', 'registration/deletePhoto?id=' . $photo->getId(), array('class' => 'delete', 'confirm' => __('Are you sure you want to delete this photo?') )) ?>
              </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <br />
    <p class="note"><?php echo __('Note: You can upload up to 6 photos') ?></p>
    <?php echo pr_label_for('new_photo', 'New Photo:') ?><br />
    <?php echo input_file_tag('new_photo', array('class' => '')) ?>
    <?php echo submit_tag('Upload') ?><br /><br />
        
    <?php echo __("YouTube URL ") ?><span><?php echo __('(enter the URL of a YouTube video - optional)') ?></span><br />
    <?php echo input_tag('youtube_url', $member->getYoutubeVidUrl(), array('class' => 'input_text_width', 'size' => 60)) ?><br />
    
    <?php echo submit_tag('', array('class' => 'save_and_cont_photos', 'name' => 'save')) ?><br />
    <span><?php echo __('Note: You can change your photos later.') ?></span>
</form>