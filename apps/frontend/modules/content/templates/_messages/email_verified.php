<?php slot('header_title') ?>
<?php echo __('Email verification') ?>
<?php end_slot(); ?>

<?php echo __('Your email address (%EMAIL%) has been verified. You may now use it to log in', array('%EMAIL%' => $sf_user->getProfile()->getEmail())) ?>