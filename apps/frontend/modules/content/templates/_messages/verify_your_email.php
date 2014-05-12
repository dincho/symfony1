<?php slot('header_title') ?>
<?php $email = $sf_user->getProfile()->getEmail(); ?>
<?php echo __('Verify your email headline', array('%EMAIL%' => $email)); ?>
<?php end_slot(); ?>

<?php echo __('For your own security, please go to your email box and verify your email by clicking on the link we have just sent you.', array('%EMAIL%' => $email)); ?>
