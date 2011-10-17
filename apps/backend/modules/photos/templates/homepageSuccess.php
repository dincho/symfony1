<?php use_helper('I18N'); ?>

<?php if( count($photos) > 0): ?>
<div class="homepage_set">
    <?php foreach($photos as $photo): ?>
            <div class="photo_slot">
                <?php echo image_tag($photo->getImageUrlPath('cropped','308x293'),array('size' => '308x293')); ?><br />
                S: <?php echo $photo->getHomepagesSet(); ?>
                <?php echo link_to('Delete', 'photos/deleteHomepagePhoto?id=' . $photo->getId()); ?>
            </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
    <p>No homepage photos found for selected catalog.</p>
<?php endif; ?>

<br class="clear" />
<?php include_component('content', 'bottomMenu', array('url' => 'photos/homepage'))?>