<?php slot('header_title') ?>
<?php echo 'Welcome headline' ?>
<?php end_slot(); ?>

<?php echo __('Welcome body', array('{REGISTRATION_URL}' => url_for('registration/index'))) ?>