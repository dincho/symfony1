<span class="public_reg_notice"><strong><?php echo __('Your Membership Status') ?></strong></span><br />
<?php echo __('You are currently a <strong>full member</strong> and you are able to send and receive messages and view unlimited profiles. If you\'re paying with Paypal, please make use your Paypal account is updated with your credit card or bank account information and that you have enough balance on your account.') ?><br /><br />
<?php if( $member->getLastPaypalItem() == 'membership'): ?>
    <span class="public_reg_notice"><strong><?php echo __('Your Auto-Renewal Status') ?></strong></span><br />
    <?php if( is_null($member->getPaypalUnsubscribedAt()) ): ?>
        <?php echo __('Your auto-renewal is ON. That means your account will be automatically charged every month for as long as you want to be a full member.', array('%EOT_DATE%' => date('M d, Y', $member->getEotDate())) ) ?>
        <br /><br />
        <?php echo __('If you unsubscribe now, you will still use Full Member account until the end of the subscription period - that is until %EOT_DATE%. On that day the system will automatically switch your membership to Basic account and you will still be able to use our website.<br />However Full Member\'s  features will not be available to you.<br />', array('%EOT_DATE%' => date('M d, Y', $member->getEotDate()))) ?>
        <br />
        <?php echo __('If you still want to unsubscribe, please click UNSUBSCRIBE button below.<br />If you changed your mind or want to unsubscribe later, please <a href="%URL_FOR_DASHBOARD%" class="sec_link_small">Cancel and go to dashboard.</a>', array('%URL_FOR_DASHBOARD%' => url_for('@dashboard'))) ?><br />
        <br /><br />
        <?php echo link_to(__('Cancel and go to dashboard'), '@dashboard', array('class' => 'sec_link')) ?><br />
        <?php echo button_to(__('Unsubscribe'), sfConfig::get('app_paypal_url') . '?cmd=_subscr-find&alias=' . urlencode(sfConfig::get('app_paypal_business')), array('popup' => true, 'class' => 'button')) ?>    
    <?php else: ?>
         <?php echo __('Your subscription is canceled. That means your account will not be automatically charged.') ?>
         <br /><br />
         <?php echo link_to(__('Return to dashboard'), '@dashboard', array('class' => 'sec_link')) ?>
    <?php endif; ?>
<?php else: ?>
    <?php echo link_to(__('Return to dashboard'), '@dashboard', array('class' => 'sec_link')) ?>    
<?php endif; ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>