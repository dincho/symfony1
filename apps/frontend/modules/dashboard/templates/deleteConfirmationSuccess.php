<?php echo form_tag('dashboard/deleteConfirmation', array('onsubmit' => 'paypal_unsubscribe()')) ?>
    <?php echo __('Please tell us why you are deleting your account. ') ?><span> <?php echo __('(optional)') ?></span><br />
    <?php echo textarea_tag('delete_reason', null, array('rows' => 5, 'cols' => 70, 'class' => 'text_area')) ?><br /><br /><br />
    <?php echo button_to(__('Cancel'), 'dashboard/index', array('class' => 'button')) ?>
    <?php echo submit_tag(__('Delete Account'), array('class' => 'button')) ?>
</form>

<script type="text/javascript" charset="utf-8">
function paypal_unsubscribe()
{
    <?php if( $member->getSubscriptionId() == SubscriptionPeer::PAID ): ?>
        var w=window.open("<?php echo sfConfig::get('app_paypal_url') . '?cmd=_subscr-find&alias=' . urlencode(sfConfig::get('app_paypal_business')); ?>");
        w.focus();
    <?php endif; ?>
    return true;
}
</script>
