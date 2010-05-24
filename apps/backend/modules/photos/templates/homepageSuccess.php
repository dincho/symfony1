<?php use_helper('I18N'); ?>

<?php if( count($photos) > 0): ?>
<div class="homepage_set">
    <?php foreach($photos as $photo): ?>
            <div class="photo_slot">
                <?php echo image_tag($photo->getWebRelativePath(), array('size' => '100x95')); ?><br />
                <?php echo $photo->getHomepages(); ?><br />
                S: <?php echo $photo->getHomepagesSet(); ?>
                P: <?php echo $photo->getHomepagesPos(); ?><br />
                Status: <?php echo $photo->getMember()->getMemberStatus(); ?><br />
                <?php echo link_to('Delete', 'photos/deleteHomepagePhoto?id=' . $photo->getId()); ?>
            </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
    <p>No homepage photos found.</p>
<?php endif; ?>