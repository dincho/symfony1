<?php slot('header_title') ?>
    <?php echo __('Areas information - %AREA%', array('%AREA%' => $adm1->getName())) ?>
<?php end_slot(); ?>

<div class="float-left" style="margin-right: 10px">
    <?php foreach($adm1->getGeoPhotos() as $photo): ?>
        <?php echo image_tag($photo->getImageUrlPath('file')) ?><br /><br />
    <?php endforeach; ?>
</div>

<div class="city_right">
    <?php echo $adm1->getInfo(ESC_RAW) ?><br /><br />
</div>

<br class="clear" />