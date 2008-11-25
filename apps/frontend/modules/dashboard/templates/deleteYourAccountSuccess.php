<?php echo __('Here you can delete your account - you will lose your information and you won\'t be able to recover it.') ?><br />
<span><?php echo __('Deleting your account cannot be reversed. You will loose all your information, including profile, photos and messages.<br />Are you sure you want to delete?') ?></span><br /><br />
<?php echo link_to(__('Yes, delete my account anyway'), 'dashboard/deleteConfirmation', array('class' => 'sec_link')) ?><br /><br />
<?php echo link_to(__('No, don\'t delete my account'), 'dashboard/index', array('class' => 'sec_link')) ?><br /><br />

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>