<?php foreach($photos as $photo): ?>
    <?php if( sfConfig::get('app_beta_period') ): ?>
        <?php echo link_to(image_tag($photo->getTiltImageUrlPath()), 'registration/joinNow') ?>
    <?php else: ?>
        <?php $looking_for = ( $photo->getGender() == 'M') ? 'F_M' : 'M_F'; ?>
        
        <?php echo link_to(image_tag($photo->getTiltImageUrlPath(), array('size' => '93x91', 'class'=>'highlighted_image' )), 'search/public?filter=filter&filters[looking_for]=' . $looking_for, array( 'class' => 'highlighted_link')) ?>
        
    <?php endif; ?>
<?php endforeach; ?>
