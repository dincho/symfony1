<?php use_helper('I18N', 'Object') ?>

<div class="legend">Edit info: <?php echo format_country($geo->getCountry()) ?> - <?php echo $geo->getName() ?></div>
<?php echo form_tag('geo/editInfo', array('multipart' => true, 'class' => 'form')) ?>
    <?php echo  object_input_hidden_tag($geo, 'getId') ?>
    <fieldset class="form_fields">
        <?php echo object_textarea_tag($geo, 'getInfo', array('cols' => 80, 'rows' => 20)) ?>
    </fieldset>
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'geo/list?cancel=1') ?>
        <?php echo submit_tag('Save') ?>
    </fieldset>
</form><br />

<div class="legend">Photos:</div>
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