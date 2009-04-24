<?php echo __('Here you can delete your account - you will lose your information and you won\'t be able to recover it. <br /><span>Deleting your account cannot be reversed. You will loose all your information, including profile, photos and messages.<br />Are you sure you want to delete?</span><br /><br /><a href="%URL_FOR_YES_DELETE%" class="sec_link">Yes, delete my account anyway</a><br /><br/><a href="%URL_FOR_NO_DELETE%" class="sec_link">No, don\'t delete my account</a>', array('%URL_FOR_YES_DELETE%' => url_for('dashboard/deleteConfirmation'), '%URL_FOR_NO_DELETE%' => url_for('dashboard/index'))) ?><br /> <br />
<br /> <br />
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>