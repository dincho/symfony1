<?php echo form_tag('dashboard/deleteConfirmation') ?>
    <?php echo __('Please tell us why you are deleting your account. ') ?><span> <?php echo __('(optional)') ?></span><br />
    <?php echo textarea_tag('delete_reason', null, array('rows' => 5, 'cols' => 70, 'class' => 'text_area')) ?><br /><br /><br />
    <?php echo button_to(__('Cancel'), 'dashboard/index', array('class' => 'button')) ?>
    <?php echo submit_tag(__('Delete Account'), array('class' => 'button')) ?>
</form>

