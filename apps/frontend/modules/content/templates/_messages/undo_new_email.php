<?php slot('header_title') ?>
<?php echo 'Email undo headline' ?>
<?php end_slot(); ?>

<?php echo __('Your have undo your email change. Your email address is back to: %EMAIL%', array('%EMAIL%' => $sf_user->getProfile()->getEmail())) ?>