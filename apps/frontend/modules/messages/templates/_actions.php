<fieldset class="text_1">
    <?php echo submit_tag(__('Delete'), array('class' => 'button_mini', 'confirm' => __('Are you sure you want to delete selected message(s)?'))) ?>
    <?php echo __('Select: ') ?> 
    <?php echo link_to_function(__('All'), 'msg_select(document.forms.'. $form_name .'.elements["selected[]"], true)', array('class' => 'sec_link')) ?>
    , <?php echo link_to_function(__('None'), 'msg_select(document.forms.'. $form_name .'.elements["selected[]"], false)', array('class' => 'sec_link')) ?>
    <?php if( !isset($no_read_unread)  ): ?>
    , <?php echo link_to_function(__('Read'), 'msg_select(document.forms.'. $form_name .'.elements["selected[]"], true, 1)', array('class' => 'sec_link')) ?>
    , <?php echo link_to_function(__('Unread (%cnt_unread%)', array('%cnt_unread%' => $cnt_unread)), 'msg_select(document.forms.'. $form_name .'.elements["selected[]"], true, 0)', array('class' => 'sec_link')) ?>
    <?php endif; ?>
</fieldset>