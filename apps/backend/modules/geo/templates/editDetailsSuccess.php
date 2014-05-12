<?php use_helper('I18N', 'Object') ?>

<div class="legend">Edit Details: <?php echo format_country($details->getGeo()->getCountry()) ?> - <?php echo $details->getGeo()->getName() ?></div>
<?php echo form_tag('geo/editDetails', array('class' => 'form')) ?>
    <?php echo  object_input_hidden_tag($details, 'getCatId') ?>
    <?php echo  object_input_hidden_tag($details, 'getId') ?>

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

<?php include_component('content', 'bottomMenu', array('url' => 'geo/editDetails?id=' . $details->getId())); ?>

<br />
<div class="legend">Photos (culture independent):</div>
<?php echo form_tag('geo/uploadPhoto', array('multipart' => true)) ?>

    <?php echo  object_input_hidden_tag($details, 'getId') ?>
    <fieldset>
        <?php echo input_file_tag('new_photo') ?>
        <?php echo submit_tag('Upload', 'class=button') ?><br />
    </fieldset><br />

    <?php foreach($details->getGeo()->getGeoPhotos() as $photo): ?>
        <div class="float-left" style="padding-right: 10px;">
            <?php echo image_tag( $photo->getImageUrlPath('file', '100x100')) ?><br />
            <?php echo link_to('Delete', 'geo/deletePhoto?id=' . $photo->getId(), array('confirm' => 'Are you sure you want to delete this photo?')) ?>
        </div>
    <?php endforeach; ?>
</form>
