<?php if( $sf_user->getCulture() != 'en' ): ?>
    <?php echo link_to(image_tag('english_version.gif', 'alt=logo'), 'content/changeLanguage?lang=en') ?>
<?php else: ?>
    <?php echo link_to(image_tag('polska_versia.gif', 'alt=logo'), 'content/changeLanguage?lang=pl') ?>
<?php endif; ?>
