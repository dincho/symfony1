<?php $last_homepage_set = array() ?>
<?php foreach($photos as $photo): ?>
    <?php if( sfConfig::get('app_beta_period') ): ?>
        <?php echo link_to(image_tag($photo->getTiltImageUrlPath()), 'registration/joinNow') ?>
    <?php else: ?>
        <?php echo link_to(image_tag($photo->getTiltImageUrlPath()), 'search/public?looking_for=' . $photo->getGender()) ?>
    <?php endif; ?>
    <?php $last_homepage_set[] = $photo->getId(); $sf_user->setAttribute('last_homepage_set', $last_homepage_set); ?>
<?php endforeach; ?>
