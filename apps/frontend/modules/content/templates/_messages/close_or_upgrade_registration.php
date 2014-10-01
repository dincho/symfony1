<?php slot('header_title') ?>
<?php echo __('Close or Upgrade your registration') ?>
<?php end_slot(); ?>

<?php echo __('Welcome back. You can upgrade your registration or close it.', array('%CNT_LOGINS%' => $sf_user->getAttribute('deactivation_counter')));
