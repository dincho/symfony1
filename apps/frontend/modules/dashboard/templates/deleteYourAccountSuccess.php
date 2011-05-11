<?php echo __('Delete your account<br /><span>Notice.<br />Are you sure?</span><br /><br /><a href="%URL_FOR_YES_DELETE%" class="sec_link">Yes</a><br /><br/><a href="%URL_FOR_NO_DELETE%" class="sec_link">No</a>', 
  array('%URL_FOR_YES_DELETE%' => url_for('dashboard/deleteConfirmation'), 
        '%URL_FOR_NO_DELETE%' => url_for('dashboard/index'))) ?>
<br /><br /><br /> <br />
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>         
