<?php slot('header_title') ?>
<?php echo __('Tell a Friend Headline') ?>
<?php end_slot(); ?>
<?php echo __('Tell a Friend body') ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu', array('auth' => $sf_user->isAuthenticated())) ?>
<?php end_slot(); ?>