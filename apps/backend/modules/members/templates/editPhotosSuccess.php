<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail(), 'class=float-right') ?>
<br /><br />

<?php echo form_tag('members/editPhotos', array('class' => 'form', 'multipart' => true)) ?>
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  <?php echo input_hidden_tag('photo_id', $sf_request->getParameter('photo_id'), 'class=hidden') ?>
  
  <div class="legend">Photos</div>
  <fieldset class="form_fields">
    <?php object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
    <?php $cnt_photos = count($photos); ?>
    <?php $i=1; foreach ($photos as $photo): ?>
        <div class="photo_slot">
        <?php echo radiobutton_tag('main_photo', $photo->getId(), $photo->isMain(), 'class=radio') ?>
        <?php if( $photo->isMain()): ?>
        <var>Main Photo</var>
        <?php endif; ?><br />
          <div id="thePhotoPrev_<?php echo $photo->getId() ?>" <?php if( isset($selected_photo) && $selected_photo->getId() == $photo->getId() ) echo 'class=selected_photo'; ?>>
            <?php echo link_to(image_tag( ($photo->getImageFilename('cropped')) ? $photo->getImageUrlPath('cropped', '100x100') : $photo->getImageUrlPath('file', '100x100') ), 'members/editPhotos?id=' . $member->getId() . '&photo_id=' . $photo->getId()) ?><br />
          </div>
        <?php echo link_to('Delete', 'members/deletePhoto?id='.$member->getId().'&photo_id='.$photo->getId(), 'confirm=Are you sure you want to delete this photo?') ?>
        </div>
        <?php if( $i++ % 5 == 0 && $i <= $cnt_photos): ?>
        </fieldset>
        <fieldset class="form_fields">
        <?php endif; ?>      
    <?php endforeach; ?>

  </fieldset>
  
  <fieldset class="form_fields">
    <label style="width: 90px">YouTube URL:</label>
    <?php echo input_tag('youtube_url', $member->getYoutubeVidUrl(), array('style' => 'width: 300px')) ?><br />
    
    <label style="width: 90px">Upload Photo:</label>
    <?php echo input_file_tag('new_photo') ?><br />
  </fieldset>
  
  <?php if( isset($selected_photo)): ?>
  <?php echo input_hidden_tag('crop_x1', null, 'class=hidden') ?>
  <?php echo input_hidden_tag('crop_y1', null, 'class=hidden') ?>
  <?php echo input_hidden_tag('crop_x2', null, 'class=hidden') ?>
  <?php echo input_hidden_tag('crop_y2', null, 'class=hidden') ?>
  <?php echo input_hidden_tag('crop_width', null, 'class=hidden') ?>
  <?php echo input_hidden_tag('crop_height', null, 'class=hidden') ?>
  
  <script type="text/javascript" charset="utf-8">
	function onEndCrop( coords, dimensions ) {
		$( 'crop_x1' ).value = coords.x1;
		$( 'crop_y1' ).value = coords.y1;
		$( 'crop_x2' ).value = coords.x2;
		$( 'crop_y2' ).value = coords.y2;
		$( 'crop_width' ).value = dimensions.width;
		$( 'crop_height' ).value = dimensions.height;
	}
  
    Event.observe( 
      window, 
      'load', 
      function() { 
        new Cropper.ImgWithPreview( 
          'thePhoto',
          { 
            minWidth: 100, 
            minHeight: 100,
            ratioDim: { x: 100, y: 100 },
            displayOnInit: true, 
            onEndCrop: onEndCrop,
            previewWrap: 'thePhotoPrev_<?php echo $selected_photo->getId() ?>'
          } 
        ) 
      } 
    );
    
  </script>
    
    <fieldset class="form_fields" id="photo_edit">
      <label class="full_row">Crop photo:</label>
      <?php echo image_tag($selected_photo->getImageUrlPath('file'), 'id=thePhoto') ?> <br />
    </fieldset>
  <?php endif; ?>
  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editPhotos?cancel=1&id='.$member->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

<?php include_partial('members/bottomMenu', array('member_id' => $member->getId())); ?>