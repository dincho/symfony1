<?php if( $sf_request->getParameter('type') == 1 && $photo->countMemberStorys()): //homepage ?>
    <p class="msg_error">This photo is also used for member stories. If you crop this photo, the member stories photo will also be affected!</p>
<?php elseif($sf_request->getParameter('type') == 2 && !is_null($photo->getHomepages())): //member stories ?>
    <p class="msg_error">This photo is also used for homepages. If you crop this photo, the homepage photo will also be affected!</p>
<?php endif; ?>

<?php echo form_tag('photos/crop?type=' . $sf_request->getParameter('type'), array('class' => 'form')) ?>
    <?php echo input_hidden_tag('photo_id', $photo->getId()) ?>
    <div class="legend">Crop Photo</div>
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
            minWidth: <?php echo $dims['w'] ?>, 
            minHeight: <?php echo $dims['h'] ?>,
            ratioDim: { x: <?php echo $dims['w'] ?>, y: <?php echo $dims['h'] ?> },
            displayOnInit: true, 
            onEndCrop: onEndCrop,
            previewWrap: 'crop_preview'
          } 
        ) 
      } 
    );
    
    </script>
    
    <div class="float-left">
        <?php echo image_tag($photo->getImageUrlPath('file'), array('id' => 'thePhoto')) ?>
    </div>
        
    <div class="float-left" style="margin-left: 50px;">
        <div id="crop_preview">
            <?php echo image_tag( $photo->getImageUrlPath('file', $dims['w'] . 'x' . $dims['h']) ) ?>
        </div>
        
        <div class="form_fields" style="margin-top: 40px;">
            <?php echo radiobutton_tag('gender', 'M', $photo->getGender() == 'M') ?><label style="text-align: left;">Male (Blue Tint)</label><br />
            <?php echo radiobutton_tag('gender', 'F', $photo->getGender() == 'F') ?><label style="text-align: left;">Female (Orange Tint)</label><br />
        </div>
    </div>

    <br /><br />
    <fieldset class="actions">
        <?php echo button_to('Cancel', $sf_user->getRefererUrl()) ?>
        <?php echo submit_tag('Save', array('name' => 'save', 'class' => 'button')) ?>
        <?php echo submit_tag('Crop & Save', array('name' => 'crop', 'class' => 'button')) ?>
    </fieldset>   
</form>
<br />
