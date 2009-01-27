<?php slot('header_title') ?>
    <?php echo __('Areas information - %AREA%', array('%AREA%' => $state->getTitle())) ?>
<?php end_slot(); ?>

<div class="float-left" style="margin-right: 10px">
    <?php foreach($state->getStatePhotos() as $photo): ?>
        <?php echo image_tag($photo->getImageUrlPath('file')) ?><br /><br />
    <?php endforeach; ?>
</div>

<div class="city_right">
    <?php echo $state->getInfo(ESC_RAW) ?><br /><br />
</div>

<br class="clear" />