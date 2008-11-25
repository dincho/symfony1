<?php slot('header_title') ?>
    <?php echo __('Verify your email') ?>
<?php end_slot(); ?>
<?php $sf_user->getBC()->add(array('name' => 'Verify your email')); ?>
<?php echo __('For your own security, please go to your email box and verify your email by clicking on the link we have just sent you.') ?>