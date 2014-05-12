<?php slot('header_title') ?>
<?php echo __('Status deactivated headline') ?>
<?php end_slot(); ?>

<?php echo __('Status deactivated body', array('%URL_FOR_DEACTIVATE_PROFILE%' => url_for('dashboard/deactivate?re=yes')));
