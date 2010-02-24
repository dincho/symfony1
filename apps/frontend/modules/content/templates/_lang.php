<?php if( $sf_user->getCulture() != 'en' ): ?>
    <?php echo link_to(__('English version'), url_for_language('en'), array('class' => 'sec_link')) ?>
<?php else: ?>
    <?php echo link_to(__('Polish version'), url_for_language('pl'), array('class' => 'sec_link')) ?>
<?php endif; ?>
