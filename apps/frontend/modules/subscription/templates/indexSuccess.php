<?php use_helper('Number', 'dtForm') ?>
<?php echo __('Subscription page headline') ?>

<?php $sub1 = $subscriptions[0]; ?>
<?php echo form_tag('subscription/index', array('id' => 'subscription')) ?>
    <fieldset style="width: 65%;">
        <div style='float: left; margin-top: 44px; width: 1px; height: 316px; border-right: 1px solid #3D3D3D;'></div>
        <div class="column" >
            <div class="upgrade_header">&nbsp;</div>
            <span class="top_one">&nbsp;</span>
            <span class="type"><?php echo __('Create a profile') ?></span><br />
            <span class="type"><?php echo __('Post a photo') ?></span><br />
            <span class="type"><?php echo __('Send and receive winks') ?></span><br />
            <span class="type"><?php echo __('Respond to messages') ?></span><br />
            <span class="type"><?php echo __('Send messages') ?></span><br />
            <span class="type"><?php echo __('See who\'s viewed your profile') ?></span><br />
            <span class="type"><?php echo __('Contact Online Assistant') ?></span><br />
            <span class="type"><?php echo __('First %PERIOD% ' . pr_format_payment_period_type($sub1->getTrial1PeriodType()), array('%PERIOD%' => $sub1->getTrial1Period()))?></span><br />
            <span class="type">
                <?php echo __('Next %PERIOD% ' . pr_format_payment_period_type($sub1->getTrial2PeriodType()), array('%PERIOD%' => $sub1->getTrial2Period())) ?>
            </span><br />
            <span class="type"><?php echo __('Then every %PERIOD% ' . pr_format_payment_period_type($sub1->getPeriodType()), array('%PERIOD%' => $sub1->getPeriod())) ?></span><br />
            <span class="select_one"><?php echo __('Select Membership') ?></span>
        </div>
        <?php foreach($subscriptions as $subscription): ?>
            <div class="column <?php if($subscription->getId() == $member->getSubscriptionId()+1) echo 'upgrade_to' ?>">
                <div class="upgrade_header">
                  <?php if($subscription->getId() == $member->getSubscriptionId()+1): ?>
                    <?php echo __('Upgrade Your Subscription Now!'); ?>
                  <?php else: ?>
                    &nbsp;
                  <?php endif; ?>
                </div>
                <span class="top"><?php echo __($subscription->getTitle()) ?></span>
                <span class="check"><?php echo image_tag('check_mark.gif') ?></span>
                <span class="check"><?php echo ($subscription->getCanPostPhoto()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                <span class="check"><?php echo ($subscription->getCanWink()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                <span class="check"><?php echo ($subscription->getCanReplyMessages()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                <span class="check"><?php echo ($subscription->getCanSendMessages()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                <span class="check"><?php echo ($subscription->getCanSeeViewed()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                <span class="check"><?php echo ($subscription->getCanContactAssistant()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>                
                <span class="check"><?php echo ($subscription->getTrial1Amount() > 0 ) ? format_currency($subscription->getTrial1Amount(), 'GBP') . __(' / %PERIOD% ' . pr_format_payment_period_type($sub1->getTrial1PeriodType()), array('%PERIOD%' => $sub1->getTrial1Period())): __('Free')?></span>                              
                <span class="check"><?php echo ($subscription->getTrial2Amount() > 0 ) ? format_currency($subscription->getTrial2Amount(), 'GBP') . __(' / %PERIOD% ' . pr_format_payment_period_type($sub1->getTrial2PeriodType()), array('%PERIOD%' => $sub1->getTrial2Period())) : __('Free')?></span>                
                <span class="check"><?php echo ($subscription->getAmount() > 0 ) ? format_currency($subscription->getAmount(), 'GBP') . __(' / %PERIOD% ' . pr_format_payment_period_type($sub1->getPeriodType()), array('%PERIOD%' => $sub1->getPeriod())) : __('Free')?></span>
                <span class="select"><?php echo radiobutton_tag('subscription_id', $subscription->getId(), ($subscription->getId() == $member->getSubscriptionId())) ?></span>
            </div>        
        <?php endforeach; ?>
 
    </fieldset>
    <br class="clear" />
    <br /><br /><br /><?php echo __('Please allow up at 48 hours for the changes to take effect.') ?><br />
    <?php echo __('Prices and avialable features subject to changes without notice. Please read <a href="%URL_FOR_TERMS%" class="sec_link">Terms of Use</a> for details.') ?>
    <br /><br /><br />
        
    <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?>
</form>
<br /><br /><br class="clear" />

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>