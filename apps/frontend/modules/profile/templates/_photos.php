<?php $i=1;foreach ($photos as $photo): ?>
    <?php if ($member->getMainPhoto()->getId() == $photo->getId()): ?>
        <?php $class = 'current_thumb';?>
        <script type="text/javascript">current_thumb_id = <?php echo $photo->getId() ?>;</script>
    <?php else: ?>
        <?php $class = 'thumb'; ?>
    <?php endif; ?>
    
    <?php $the_img = image_tag($photo->getImg('50x50'), array('id' => 'thumb_' . $photo->getId(), 'class' => $class)); ?>
    <?php $show_profile_image = sprintf('show_profile_image("%s", %d, "%s", "lightbox[%s]")', $photo->getImg('350x350', 'file'), $photo->getId(), $photo->getImageUrlPath('file'), $block_id); ?>
    <?php echo link_to_function($the_img, $show_profile_image, array()); ?>
    
    <?php //this is ugly lightbox hack, seems that it's very basic lib and connot be customized and used in edge case conditions ?>
    <?php echo content_tag('a', null, array('href' => $photo->getImageUrlPath('file'), 'rel' => 'lightbox['.$block_id.']')); ?>
    
    <?php if($i++ % 6 == 0 ): ?>
        <br />
    <?php endif; ?>
<?php endforeach; ?>

