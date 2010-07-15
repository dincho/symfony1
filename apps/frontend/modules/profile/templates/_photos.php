<?php $i=1;foreach ($photos as $photo): ?>
    <?php if ($member->getMainPhoto()->getId() == $photo->getId()): ?>
        <?php $class = 'current_thumb';?>
        <script type="text/javascript">current_thumb_id = <?php echo $photo->getId() ?>;</script>
    <?php else: ?>
        <?php $class = 'thumb'; ?>
    <?php endif; ?>
    <?php $the_img = image_tag($photo->getImg('50x50'), array('id' => 'thumb_' . $photo->getId(), 'class' => $class)); ?>
    <?php echo link_to_function($the_img, 'show_profile_image("'. $photo->getImg('350x350', 'file').'", '. $photo->getId() .', "'. $photo->getImageUrlPath('file') .'")', array()) ?>
    <?php if($i++ % 6 == 0 ): ?>
        <br />
    <?php endif; ?>
<?php endforeach; ?>