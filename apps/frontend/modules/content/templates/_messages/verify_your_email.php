<?php slot('header_title') ?>
<?php echo __('Verify your email headline') ?>
<?php end_slot(); ?>

<?php $email = $sf_user->getProfile()->getEmail(); ?>
<?php echo __('For your own security, please go to your email box and verify your email by clicking on the link we have just sent you.', array('%EMAIL%' => $email)); ?>