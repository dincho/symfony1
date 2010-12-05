<?php use_helper('I18N') ?>

<?php echo form_tag('photos/addMemberPhotoToHomepage', array('class' => 'form')) ?>
    <?php echo input_hidden_tag('photo_id', $photo->getId()) ?>
    
    <fieldset class="form_fields">
        <div class="legend">Crop Photo</div>
        <?php echo input_hidden_tag('crop_x1', null, 'class=hidden') ?>
        <?php echo input_hidden_tag('crop_y1', null, 'class=hidden') ?>
        <?php echo input_hidden_tag('crop_x2', null, 'class=hidden') ?>
        <?php echo input_hidden_tag('crop_y2', null, 'class=hidden') ?>
        <?php echo input_hidden_tag('crop_width', null, 'class=hidden') ?>
        <?php echo input_hidden_tag('crop_height', null, 'class=hidden') ?>
    
        <div class="float-left">
            <?php echo image_tag($photo->getImageUrlPath('file'), array('id' => 'thePhoto')) ?>
        </div>
        
        <div class="float-left" style="margin-left: 50px;">
            <div id="crop_preview">
                <?php echo image_tag( $photo->getImageUrlPath('file', $dims['w'] . 'x' . $dims['h']) ) ?>
            </div><br />
        
            <div>
                <?php echo radiobutton_tag('gender', 'M', $photo->getMember()->getSex() == 'M') ?><label style="text-align: left;">Male</label><br />
                <?php echo radiobutton_tag('gender', 'F', $photo->getMember()->getSex() == 'F') ?><label style="text-align: left;">Female</label><br /><br />

                <?php echo select_tag('homepages_set', options_for_select(array(1 => 'S1', 2 => 'S2', 3 => 'S3'), null, 'include_blank=true'), array('class' => 'limit_input')) ?>
                <label style="width: 130px; text-align: left;">Homepage set</label><br />
                
                <?php echo select_tag('homepages_pos', options_for_select(array(1 => 'A1', 2 => 'B1', 3 => 'C1', 4 => 'A2', 5 => 'B2', 6 => 'C2', 7 => 'A3', 8 => 'B3', 9 => 'C3'), null, 'include_blank=true'), array('class' => 'limit_input')) ?>
                <label style="width: 130px; text-align: left;">Homepage position</label><br />
        
                <table class="zebra" style="width: 300px">
                    <tr>
                        <th colspan="2">Languages</th>
                    </tr>
                    <?php foreach($catalogs as $catalog): ?>
                        <tr>
                            <td style="width:5px; padding: 0;"><?php echo checkbox_tag('catalogs[]', $catalog->getCatId(), false) ?></td>
                            <td><?php echo $catalog; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            
            </div>
        </div>

    </fieldset>
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', $sf_user->getRefererUrl()) ?>
        <?php echo submit_tag('Save', array('name' => 'save', 'class' => 'button')) ?>
    </fieldset>  
</form>


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