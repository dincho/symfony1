<?php echo __('You may change your photos here') ?><br />
<span><?php echo __('Make changes and click Save on the bottom of the page.') ?></span><br /><br />
<?php echo __('You may upload any size of photo - we will shrink it to 700x700 pixels maximum; your high quality will be preserved.') ?><br />
<?php echo __('Use these formats only: jpg, png and gif.') ?><br /><br />
                
<?php echo form_tag('editProfile/photos', array('multipart' => true)) ?>
    <?php if(count($photos) > 0): ?>
        <div id="photos">
            <?php foreach ($photos as $photo): ?>
              <div class="photo">
                <?php echo radiobutton_tag('main_photo', $photo->getId(), $photo->isMain()) ?>
                <?php if( $photo->isMain()): ?>
                    <label for="main_photo"><?php echo __('Main Photo') ?></label>
                <?php endif; ?><br />
                  <span>
                    <?php echo image_tag( $photo->getImageUrlPath('file', '100x100') ) ?>
                  </span>
                <?php echo button_to('', 'profile/deletePhoto?id=' . $photo->getId(), array('class' => 'delete', 'confirm' => __('Are you sure you want to delete this photo?') )) ?>
              </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <br />
    <p class="note"><?php echo __('Note: You can upload up to 6 photos') ?></p>
    <label for="new_photo"><?php echo __('New Photo:') ?></label><br />
    <?php echo input_file_tag('new_photo', array('class' => '')) ?>
    <?php echo submit_tag('Upload', 'id=upload') ?><br /><br />
        
    <?php echo __('YouTube URL ') ?><span><?php echo __('(enter the URL of a YouTube video - optional)') ?></span><br />
    <?php echo input_tag('youtube_url', $member->getYoutubeVidUrl(), array('class' => 'input_text_width', 'size' => 60)) ?><br />
    
    <br /><br /><?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link')) ?><br />
    <?php echo submit_tag('Save', array('class' => 'save', 'name' => 'save')) ?>
</form>