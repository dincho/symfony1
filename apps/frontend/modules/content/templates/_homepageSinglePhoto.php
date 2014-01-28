<?php foreach($photos as $photo): ?>
    <?php if( sfConfig::get('app_beta_period') ): ?>
        <?php echo link_to(image_tag($photo->getImageUrlPath('cropped', '308x293'), array('size' => '308x293')), 'registration/joinNow') ?>
    <?php else: ?>
        <?php $looking_for = ( $photo->getGender() == 'M') ? 'F_M' : 'M_F'; ?>
        <?php echo link_to(image_tag($photo->getImageUrlPath('cropped', '308x293'), array('size' => '308x293')), 'registration/joinNow', array( 'class' => 'highlighted_link')) ?>
                          
    <?php endif; ?>
<?php endforeach; ?>
