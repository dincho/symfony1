<div class="float-left" style="margin-right: 10px">
    <?php foreach($geo->getGeoPhotos() as $photo): ?>
        <?php echo image_tag($photo->getImageUrlPath('file')) ?><br /><br />
    <?php endforeach; ?>
</div>

<div class="city_right">
    <?php echo $geo->getInfo(ESC_RAW) ?><br /><br />
</div>

<br class="clear" />