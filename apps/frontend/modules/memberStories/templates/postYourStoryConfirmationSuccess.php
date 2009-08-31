<?php echo __('Post your story confirmation body'); ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu', array('auth' => $sf_user->isAuthenticated())) ?>
<?php end_slot(); ?>