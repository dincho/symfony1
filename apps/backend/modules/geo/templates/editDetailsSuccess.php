<?php use_helper('I18N', 'Object') ?>

<div class="legend">Edit Details: <?php echo format_country($geo->getCountry()) ?> - <?php echo $geo->getName() ?></div>
<?php echo form_tag('geo/editDetails', array('class' => 'form')) ?>
    <?php echo  object_input_hidden_tag($geo, 'getId') ?>
    <?php echo  object_input_hidden_tag($details, 'getCulture') ?>
    
    
    <fieldset class="form_fields float-left">
        <label for="member_info">Member Info:</label><br />
        <?php echo object_textarea_tag($details, 'getMemberInfo', array('cols' => 80, 'rows' => 20)) ?>
    </fieldset>
   
    <fieldset class="form_fields float-left">
        <label for="seo_info">Seo Info:</label><br />
        <?php echo object_textarea_tag($details, 'getSeoInfo', array('cols' => 80, 'rows' => 20)) ?>
    </fieldset>
    <br />
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'geo/list?cancel=1') ?>
        <?php echo submit_tag('Save') ?>
    </fieldset>
</form><br class="clear" />

<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($details->getCulture() == 'en', 'English', 'geo/editDetails?culture=en&id=' . $geo->getId()) ?>&nbsp;|</li>
    <li><?php echo link_to_unless($details->getCulture() == 'pl', 'Polish', 'geo/editDetails?culture=pl&id=' . $geo->getId()) ?>&nbsp;</li>
  </ul>
</div>

<br />
<div class="legend">Photos (culture independent):</div>
<?php echo form_tag('geo/uploadPhoto', array('multipart' => true)) ?>
    
    <?php echo  object_input_hidden_tag($geo, 'getId') ?>
    <fieldset>
        <?php echo input_file_tag('new_photo') ?>
        <?php echo submit_tag('Upload', 'class=button') ?><br />
    </fieldset><br />

    <?php foreach($geo->getGeoPhotos() as $photo): ?>
        <div class="float-left" style="padding-right: 10px;">
            <?php echo image_tag( $photo->getImageUrlPath('file', '100x100')) ?><br />
            <?php echo link_to('Delete', 'geo/deletePhoto?id=' . $photo->getId(), array('confirm' => 'Are you sure you want to delete this photo?')) ?>
        </div>
    <?php endforeach; ?>
</form>

