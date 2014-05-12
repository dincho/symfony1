<fieldset class="text_1">
    &nbsp;
    <?php echo submit_tag(__('Delete'), array('class' => 'button_mini', 'disabled' => $sf_request->getParameter('confirm_delete') )) ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo __('Select: ') ?>
    <?php echo link_to_function(__('All'), 'msg_select(document.forms.'. $form_name .'.elements["selected[]"], true)', array('class' => 'sec_link')) ?>
    , <?php echo link_to_function(__('None'), 'msg_select(document.forms.'. $form_name .'.elements["selected[]"], false)', array('class' => 'sec_link')) ?>
    <?php if( !isset($no_read_unread)  ): ?>
    , <?php echo link_to_function(__('Read'), 'msg_select(document.forms.'. $form_name .'.elements["selected[]"], true, 1)', array('class' => 'sec_link')) ?>
    , <?php
    echo link_to_function(__('Unread <strong>(%cnt_unread%)</strong>', array('%cnt_unread%' => $cnt_unread)), 'msg_select(document.forms.'. $form_name .'.elements["selected[]"], true, 0)', array('class' => 'sec_link'));
     ?>
    <?php endif; ?>
</fieldset>
