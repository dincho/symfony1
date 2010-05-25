<?php use_helper('Number', 'dtForm') ?>
<?php echo __('Subscription page headline') ?>

<?php $sub1 = $subscriptions[0]; ?>
<?php $better_subscription_flag = false; ?>

<?php echo form_tag('subscription/index', array('id' => 'subscription')) ?>
    <fieldset style="width: 90%;">
        <div style='float: left; margin-top: 44px; width: 1px; height: 294px; border-right: 1px solid #3D3D3D;'></div>
        <div class="column" >
            <div class="upgrade_header">&nbsp;</div>
            <div class="subscription_features">
              <span class="top">&nbsp;</span>
              <span class="type"><?php echo __('Create a profile') ?></span><br />
              <span class="type"><?php echo __('Post a photo') ?></span><br />
              <span class="type"><?php echo __('Send and receive winks') ?></span><br />
              <span class="type"><?php echo __('Respond to messages') ?></span><br />
              <span class="type"><?php echo __('Send messages') ?></span><br />
              <span class="type"><?php echo __('See who\'s viewed your profile') ?></span><br />
              <span class="type"><?php echo __('Contact Online Assistant') ?></span><br />
              <span class="type"><?php echo __('Private Dating') ?></span><br />
              <span class="type">
                  <?php echo __('Fee per %PERIOD% ' . pr_format_payment_period_type($sub1->getPeriodType()), array('%PERIOD%' => $sub1->getPeriod())) ?>
              </span><br />
              <span class="select"><?php echo __('Select Membership') ?>&nbsp;</span>
            </div>
        </div>
        <?php foreach($subscriptions as $subscription): ?>
            <?php $is_better = ( $subscription->getAmount() > $member->getSubscription()->getAmount()) ? true : false; ?>
            <div class="column <?php if( $subscription->getAmount() > 0 ) echo 'upgrade_to' ?>">
                <div class="upgrade_header">
                  <?php if( $is_better  ): ?>
                    <div><?php echo __('Upgrade to %SUBSCRIPTION_TITLE% account!', array('%SUBSCRIPTION_TITLE%' => $subscription->getTitle())); ?></div>
                  <?php else: ?>
                    &nbsp;
                  <?php endif; ?>
                </div>
                <div class="<?php echo ( $subscription->getAmount() > 0 ) ? 'outlined_subscription_features' : 'subscription_features';?>">
                  <span class="top"><?php echo __($subscription->getTitle()) ?></span>
                  <span class="check"><?php echo image_tag('check_mark.gif') ?></span>
                  <span class="check"><?php echo ($subscription->getCanPostPhoto()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getCanWink()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getCanReplyMessages()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getCanSendMessages()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getCanSeeViewed()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getCanContactAssistant()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getPrivateDating()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getAmount() > 0 ) ? format_currency($subscription->getAmount(), sfConfig::get('app_settings_currency_' . $sf_user->getCulture(), 'GBP')) : __('Free')?></span>
                  <span class="select">
                    <?php if( $is_better): ?>
                      <?php $better_subscription_flag = true; ?>
                      <?php echo button_to(__('Upgrade to %SUBSCRIPTION_TITLE%',  array('%SUBSCRIPTION_TITLE%' => $subscription->getTitle())), 
                                          'subscription/payment?sid=' . $subscription->getId(), array('class' => 'button')); ?>
                    <?php else: ?>
                      &nbsp;
                    <?php endif; ?>
                  </span>
                </div>
            </div>        
        <?php endforeach; ?>
    </fieldset>
    <br class="clear" />
    <br /><br /><br /><?php echo __('Please allow up at 48 hours for the changes to take effect.') ?><br />
    <?php echo __('Prices and avialable features subject to changes without notice. Please read <a href="%URL_FOR_TERMS%" class="sec_link">Terms of Use</a> for details.') ?>
    <br /><br /><br />
        
    <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
</form>
<br /><br /><br class="clear" />

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>