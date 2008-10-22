<?php use_helper('Number') ?>
<?php echo __('You are currently using our <strong>free of charge account</strong> that allows to send and receive limited winks and reply to messages.<br />
In order to see more matches and send messages, please upgrade your subscription below and click save. <br />') ?>

<?php echo form_tag('subscription/index', array('id' => 'subscription')) ?>
    <fieldset>
        <div class="column">
            <div class="upgrade_img">&nbsp;</div>
            <span class="top">&nbsp;</span>
            <span class="type"><?php echo __('Create a profile') ?></span><br />
            <span class="type"><?php echo __('Post a photo') ?></span><br />
            <span class="type"><?php echo __('Send & receive winks') ?></span><br />
            <span class="type"><?php echo __('Respond to messages') ?></span><br />
            <span class="type"><?php echo __('Send messages') ?></span><br />
            <span class="type"><?php echo __('See who\'s viewed your profile') ?></span><br />
            <span class="type"><?php echo __('Contact Online Assistant') ?></span><br />
            <span class="type"><?php echo __('First Month') ?></span><br />
            <span class="type"><?php echo __('Month 2 through 6') ?></span><br />
            <span class="type"><?php echo __('Month 7+') ?></span><br />
            <span class="select"><?php echo __('Select Membership') ?></span>
        </div>
        <?php foreach($subscriptions as $subscription): ?>
            <div class="column <?php if($subscription->getId() == $member->getSubscriptionId()+1) echo 'upgrade_to' ?>">
                <div class="upgrade_img">&nbsp;</div>
                <span class="top"><?php echo $subscription->getTitle() ?></span>
                <span class="check"><?php echo image_tag('check_mark.gif') ?></span>
                <span class="check"><?php echo ($subscription->getCanPostPhoto()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                <span class="check"><?php echo ($subscription->getCanWink()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                <span class="check"><?php echo ($subscription->getCanReplyMessages()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                <span class="check"><?php echo ($subscription->getCanSendMessages()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                <span class="check"><?php echo ($subscription->getCanSeeViewed()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                <span class="check"><?php echo ($subscription->getCanContactAssistant()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                <span class="check"><?php echo ($subscription->getPeriod1Price() > 0 ) ? format_currency($subscription->getPeriod1Price(), 'GBP') : __('Free')?></span>
                <span class="check"><?php echo ($subscription->getPeriod2Price() > 0 ) ? format_currency($subscription->getPeriod2Price(), 'GBP') : __('Free')?></span>
                <span class="check"><?php echo ($subscription->getPeriod3Price() > 0 ) ? format_currency($subscription->getPeriod3Price(), 'GBP') : __('Free')?></span>
                <span class="select"><?php echo radiobutton_tag('subscription_id', $subscription->getId(), ($subscription->getId() == $member->getSubscriptionId())) ?></span>
            </div>        
        <?php endforeach; ?>
        <!-- 
        <div class="column">
            <div class="upgrade_img">&nbsp;</div>
            <span class="top">Free Membership</span>
            <span class="check"><img src="/images/check_mark.gif" alt="" /></span>
            <span class="check"><img src="/images/check_mark.gif" alt="" /></span>
            <span class="check"><img src="/images/check_mark.gif" alt="" /></span>
            <span class="check"><img src="/images/check_mark.gif" alt="" /></span>
            <span class="check">&nbsp;</span>
            <span class="check">&nbsp;</span>
            <span class="check">&nbsp;</span>
            <span class="check">Free</span>
            <span class="check">Free</span>
            <span class="check">Free</span>
            <span class="select"><input type="radio" name="subscribe" id="sub1" /></span>
        </div>
        <div class="column upgrade_to">
            <div class="upgrade_img">&nbsp;</div>
            <span class="top">Full Membership</span>
            <span class="check"><img src="/images/check_mark.gif" alt="" /></span>
            <span class="check"><img src="/images/check_mark.gif" alt="" /></span>
            <span class="check"><img src="/images/check_mark.gif" alt="" /></span>
            <span class="check"><img src="/images/check_mark.gif" alt="" /></span>
            <span class="check"><img src="/images/check_mark.gif" alt="" /></span>
            <span class="check"><img src="/images/check_mark.gif" alt="" /></span>
            <span class="check"><img src="/images/check_mark.gif" alt="" /></span>
            <span class="check">&pound;14.95</span>
            <span class="check">&pound;9.95</span>
            <span class="check">&pound;6.95</span>
            <span class="select"><input type="radio" name="subscribe" id="sub2" /></span>
        </div>
         -->
    </fieldset>
    <br class="clear" />
        <br /><br /><br /><?php echo __('Please allow up at 48 hours for the changes to take effect.') ?><br />
        <?php echo __('Prices and avialable features subject to changes without notice. Please read %link_to_user_agreement% for details.', 
                            array('%link_to_user_agreement%' => link_to(__('Terms of Use'), '@page?slug=user_agreement', array('class' => 'sec_link')))) ?>
        <br /><br /><br />
        
        <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link')) ?><br />
        <?php echo submit_tag('Save', array('class' => 'save')) ?>
</form>
<br class="clear" />