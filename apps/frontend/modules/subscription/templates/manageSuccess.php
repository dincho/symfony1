<?php echo form_tag('subscription/manage', array('id' => 'subscription_paid')) ?>
    <span class="public_reg_notice"><strong><?php echo __('Your Membership Status') ?></strong></span><br />
    <?php echo __('You are currently a <strong>full member</strong> and you are able to send and receive messages and view unlimited profiles. If you\'re paying with Paypal, please make use your Paypal account is updated with your credit card or bank account information and that you have enough balance on your account.') ?><br /><br />
    <span class="public_reg_notice"><strong><?php echo __('Your Auto-Renewal Status') ?></strong></span><br />
    <?php if( $member->getSubAutoRenew() ): ?>
        <?php echo __('Your auto-renewal is ON. That means your account will be automatically charged every month for as long as you want to be a full member.') ?>
    <?php else: ?>
         <?php echo __('Your auto-renewal is OFF. That means your account will not be automatically charged.') ?>
    <?php endif; ?>
    <br />
    
    <?php echo radiobutton_tag('sub_auto_renew', 0, !$member->getSubAutoRenew()) ?>
    <label for="sub_auto_renew_0"><?php echo __('Off') ?></label><br />
    <?php echo radiobutton_tag('sub_auto_renew', 1, $member->getSubAutoRenew()) ?>
    <label for="sub_auto_renew_1"><?php echo __('On') ?></label><br /><br />
    
    <?php echo __('If you switch auto-renewal to OFF, you can still be a full member but you will be required to make the payment every month manually; we will send you reminder by email. If you don\'t want to be a full member anymore, switch auto-renewal to OFF and just don\'t make manual payments. To find out more please go to %LINK_TO_HELP%', array('%LINK_TO_HELP%' => link_to(__('Help'), '@page?slug=help', 'class=sec_link')) ) ?>.<br /><br /><br />
    <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?>
</form>

<?php //echo link_to('Unsubscribe', sfConfig::get('app_paypal_url') . '?cmd=_subscr-find&alias=' . urlencode(sfConfig::get('app_paypal_business')), array('popup' => true)) ?>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>