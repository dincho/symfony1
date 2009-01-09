<?php slot('header_title') ?>
    <?php echo __('Status suspended headline') ?>
<?php end_slot(); ?>

<?php echo __('Status suspended body', array('{USER_AGREEMENT_URL}' => url_for('@page?slug=user_agreement')));