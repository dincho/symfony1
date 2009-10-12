<?php foreach($photos as $photo): ?>
    <?php if( sfConfig::get('app_beta_period') ): ?>
        <?php echo link_to(image_tag($photo->getTiltImageUrlPath(), array('size' => '100x95')), 'registration/joinNow') ?>
    <?php else: ?>
        <?php $looking_for = ( $photo->getGender() == 'M') ? 'F_M' : 'M_F'; ?>
        
        <?php echo link_to(image_tag($photo->getTiltImageUrlPath(), array('size' => '100x95')), 
                          'search/public?filter=filter&filters[looking_for]=' . $looking_for, array( 'class' => 'highlighted_link')) ?>
    <?php endif; ?>
<?php endforeach; ?>
